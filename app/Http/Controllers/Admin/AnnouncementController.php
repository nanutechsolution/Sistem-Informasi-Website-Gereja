<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement; // Pastikan model Announcement di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Untuk menangani error validasi
use App\Models\Notification; // <-- TAMBAHKAN INI
use App\Models\User; // <-- TAMBAHKAN INI, untuk mendapatkan semua admin
class AnnouncementController extends Controller
{
    /**
     * Tampilkan daftar semua pengumuman.
     */
    public function index()
    {
        // Ambil semua pengumuman, urutkan berdasarkan tanggal publikasi terbaru
        $announcements = Announcement::latest('published_at')->paginate(10); // Menambahkan pagination

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Tampilkan form untuk membuat pengumuman baru.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Simpan pengumuman baru ke database.
     */
    public function store(Request $request)
    {
        try {
            // Lakukan validasi dan simpan hasilnya ke $validatedData
            $validatedData = $request->validate([ // <-- Simpan hasil validate ke variabel ini
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'published_at' => 'nullable|date',
            ]);

            // Set nilai default untuk published_at jika kosong
            $validatedData['published_at'] = $validatedData['published_at'] ?? now();

            // Cukup buat pengumuman SATU KALI dan simpan hasilnya ke $announcement
            $announcement = Announcement::create($validatedData); // <-- PERBAIKAN PENTING DI SINI

            // --- KODE NOTIFIKASI (Sekarang akan menggunakan $announcement yang benar) ---
            $adminUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'sekretaris']);
            })->get();

            foreach ($adminUsers as $user) {
                Notification::create([
                    'type' => 'new_announcement',
                    'title' => 'Pengumuman Baru Ditambahkan',
                    'message' => 'Pengumuman "' . $announcement->title . '" telah ditambahkan.',
                    'user_id' => $user->id,
                    'link' => route('admin.announcements.show', $announcement->id), // Pastikan ini mengarah ke route show
                ]);
            }
            // --- AKHIR KODE NOTIFIKASI ---

            return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        // Tangani exception lainnya jika diperlukan, seperti yang ada di controller lain
        catch (\Exception $e) {
            // \Log::error('Error storing Announcement:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail pengumuman (opsional untuk admin, lebih sering di publik).
     */
    public function show(Announcement $announcement)
    {
        // Untuk sisi admin, show mungkin jarang digunakan langsung,
        // lebih sering langsung ke edit. Tapi tetap bisa diimplementasikan.
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Tampilkan form untuk mengedit pengumuman.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Perbarui pengumuman di database.
     */
    public function update(Request $request, Announcement $announcement)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'published_at' => 'nullable|date',
            ]);

            $announcement->update([
                'title' => $request->title,
                'content' => $request->content,
                'published_at' => $request->published_at ?? now(),
            ]);

            return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Hapus pengumuman dari database.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}
