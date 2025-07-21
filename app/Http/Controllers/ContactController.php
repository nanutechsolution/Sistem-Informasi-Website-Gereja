<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Import Mail Facade
use App\Mail\ContactFormMail; // Import Mailable Class
use App\Models\ContactMessage;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Tangani pengiriman formulir kontak.
     */
    public function submit(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message_content' => 'required|string|min:10', // Ubah nama variabel agar tidak konflik
                'g-recaptcha-response' => config('app.env') === 'production' ? 'required|recaptcha' : 'nullable', // Hanya di produksi
            ]);

            // --- BAGIAN YANG HILANG/BELUM ADA: SIMPAN PESAN KONTAK KE DATABASE ---
            // Anda perlu model dan migrasi untuk ContactMessage jika belum ada.
            // Jika belum ada, Anda bisa buat dulu: php artisan make:model ContactMessage -m
            // Lalu isi migrasi dengan kolom: name, email, message_content, subject (opsional)
            $contactMessage = ContactMessage::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'subject' => $request->input('subject') ?? 'Pesan dari Kontak Form', // Asumsi ada input 'subject' di form atau default
                'message_content' => $validatedData['message_content'],
            ]);
            Log::info('Contact message saved to DB.', ['message_id' => $contactMessage->id]);
            // --- AKHIR BAGIAN PENYIMPANAN PESAN KONTAK ---


            // Kirim email ke alamat email gereja
            Mail::to(config('mail.from.address'))->send(new ContactFormMail(
                $validatedData['name'],
                $validatedData['email'],
                $validatedData['message_content']
            ));


            // --- BAGIAN YANG HILANG/BELUM ADA: BUAT NOTIFIKASI ---
            $adminUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'sekretaris']); // Notifikasi untuk admin/sekretaris
            })->get();

            Log::info('Admin/Sekretaris users found for notification.', ['count' => $adminUsers->count(), 'users_email' => $adminUsers->pluck('email')->toArray()]);

            if ($adminUsers->isEmpty()) {
                Log::warning('No admin/sekretaris users found for contact form notification. Notification will not be created.');
            }

            foreach ($adminUsers as $user) {
                $notificationData = [
                    'type' => 'new_contact_message',
                    'title' => 'Pesan Kontak Baru Diterima!',
                    'message' => 'Dari: ' . $contactMessage->name . ' | Subjek: ' . ($contactMessage->subject ?? 'Tanpa Subjek'),
                    'user_id' => $user->id,
                    'link' => '#', // Untuk saat ini, karena belum ada modul admin untuk melihat pesan kontak.
                    // Nanti bisa diubah ke route('admin.contact-messages.show', $contactMessage->id)
                ];
                Notification::create($notificationData);
                Log::info('Notification created for user ' . $user->email, $notificationData);
            }
            // --- AKHIR BAGIAN NOTIFIKASI ---

            return redirect()->route('public.contact')->with('success', 'Pesan Anda berhasil terkirim. Kami akan segera menghubungi Anda!');
        } catch (ValidationException $e) {
            Log::error('Contact form validation failed.', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error in ContactController@submit:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pesan Anda. Silakan coba lagi nanti.')->withInput();
        }
    }
}
