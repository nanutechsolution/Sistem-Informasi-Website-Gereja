<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event; // Pastikan model Event di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Untuk slug (penting!)
use Illuminate\Support\Facades\Storage; // Untuk upload file (penting!)
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login

class EventController extends Controller
{
    /**
     * Tampilkan daftar semua acara.
     */
    public function index()
    {
        $events = Event::with('user')->latest('start_time')->paginate(10); // Eager load user
        return view('admin.events.index', compact('events'));
    }

    /**
     * Tampilkan form untuk membuat acara baru.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Simpan acara baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'start_time' => 'required|date',
                'end_time' => 'nullable|date|after_or_equal:start_time',
                'organizer' => 'nullable|string|max:255',
                'status' => 'required|string|in:scheduled,cancelled,completed', // Jika Anda masih pakai 'status'
                'is_published' => 'boolean', // Jika Anda pakai 'is_published'
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            ]);

            // Slug akan di-generate otomatis oleh model's boot method
            // $validatedData['slug'] = Str::slug($validatedData['title']);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('event_images', 'public');
                $validatedData['image'] = $imagePath;
            }

            // Set user_id dari user yang sedang login
            $validatedData['user_id'] = Auth::id();

            // Set default is_published jika tidak ada di request (checkbox tidak tercentang)
            $validatedData['is_published'] = $request->has('is_published');


            Event::create($validatedData);

            return redirect()->route('admin.events.index')->with('success', 'Acara berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing Event:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Perbarui acara di database.
     */
    public function update(Request $request, Event $event)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'location' => 'nullable|string|max:255',
                'start_time' => 'required|date',
                'end_time' => 'nullable|date|after_or_equal:start_time',
                'organizer' => 'nullable|string|max:255',
                'status' => 'required|string|in:scheduled,cancelled,completed',
                'is_published' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Slug akan di-generate otomatis oleh model's boot method jika title berubah
            // if ($request->title !== $event->title) {
            //     $validatedData['slug'] = Str::slug($validatedData['title']);
            // }

            // Handle image upload/update
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($event->image && Storage::disk('public')->exists($event->image)) {
                    Storage::disk('public')->delete($event->image);
                }
                $imagePath = $request->file('image')->store('event_images', 'public');
                $validatedData['image'] = $imagePath;
            } else {
                // Pertahankan gambar lama jika tidak ada gambar baru diupload
                $validatedData['image'] = $event->image;
            }

            // Set is_published jika tidak ada di request
            $validatedData['is_published'] = $request->has('is_published');

            $event->update($validatedData);

            return redirect()->route('admin.events.index')->with('success', 'Acara berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating Event:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus acara dari database.
     */
    public function destroy(Event $event)
    {
        try {
            // Hapus gambar terkait jika ada
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
            $event->delete();
            return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Event:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}