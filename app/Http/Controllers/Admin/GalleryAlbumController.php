<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum; // Pastikan model GalleryAlbum di-import
use App\Models\Media; // Pastikan model Media di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Str; // Untuk manipulasi string
class GalleryAlbumController extends Controller
{
    /**
     * Tampilkan daftar semua album galeri.
     */
    public function index()
    {
        // Ambil semua album, urutkan berdasarkan tanggal event terbaru
        $albums = GalleryAlbum::latest('event_date')->paginate(10);

        return view('admin.gallery.albums.index', compact('albums'));
    }

    /**
     * Tampilkan form untuk membuat album baru.
     */
    public function create()
    {
        return view('admin.gallery.albums.create');
    }

    /**
     * Simpan album baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'event_date' => 'nullable|date',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $imagePath = $request->file('cover_image')->store('gallery_covers', 'public');
                $validatedData['cover_image'] = $imagePath;
            }

            GalleryAlbum::create($validatedData);

            return redirect()->route('admin.gallery-albums.index')->with('success', 'Album galeri berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Tampilkan detail album dan media di dalamnya.
     * Ini akan berfungsi sebagai halaman manajemen media untuk album tertentu.
     */
    public function show(GalleryAlbum $album)
    {
        // Eager load media untuk album ini
        $album->load('media');
        return view('admin.gallery.albums.show', compact('album'));
    }

    /**
     * Tampilkan form untuk mengedit album.
     */
    public function edit(GalleryAlbum $album)
    {
        return view('admin.gallery.albums.edit', compact('album'));
    }

    /**
     * Perbarui album di database.
     */
    public function update(Request $request, GalleryAlbum $album)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'event_date' => 'nullable|date',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Handle cover image update
            if ($request->hasFile('cover_image')) {
                if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
                    Storage::disk('public')->delete($album->cover_image);
                }
                $imagePath = $request->file('cover_image')->store('gallery_covers', 'public');
                $validatedData['cover_image'] = $imagePath;
            } else {
                // Jika tidak ada gambar baru, pertahankan yang lama
                $validatedData['cover_image'] = $album->cover_image;
            }

            $album->update($validatedData);

            return redirect()->route('admin.gallery-albums.index')->with('success', 'Album galeri berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Hapus album dari database (akan menghapus semua media terkait karena onDelete('cascade')).
     */
    public function destroy(GalleryAlbum $album)
    {
        // Hapus cover image jika ada
        if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
            Storage::disk('public')->delete($album->cover_image);
        }

        // Media di dalam album akan dihapus otomatis oleh foreign key cascade
        // Namun, file fisik media juga perlu dihapus
        foreach ($album->media as $mediaItem) {
            if (Storage::disk('public')->exists($mediaItem->path)) {
                Storage::disk('public')->delete($mediaItem->path);
            }
            if ($mediaItem->thumbnail_path && Storage::disk('public')->exists($mediaItem->thumbnail_path)) {
                Storage::disk('public')->delete($mediaItem->thumbnail_path);
            }
        }

        $album->delete();

        return redirect()->route('admin.gallery-albums.index')->with('success', 'Album galeri dan semua isinya berhasil dihapus!');
    }


    // --- Fungsionalitas Manajemen Media di dalam Album ---

    /**
     * Upload media baru ke album tertentu.
     */
    /**
     * Upload media baru ke album tertentu.
     */
    public function uploadMedia(Request $request, GalleryAlbum $album)
    {
        $request->validate([
            'media_files.*' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,ogg,qt|max:20480', // Max 20MB per file
            'media_captions.*' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $key => $file) {
                $type = Str::contains($file->getMimeType(), 'video') ? 'video' : 'image';
                $filePath = $file->store('gallery_media/' . $album->id, 'public'); // Simpan di folder spesifik album

                // --- PERBAIKI BAGIAN INI ---
                $media = new Media([
                    'type' => $type,
                    'path' => $filePath,
                    'caption' => $request->media_captions[$key] ?? null,
                    'gallery_album_id' => $album->id, // Pastikan ini juga diisi
                    'mediable_id' => $album->id, // ID dari model yang berelasi (GalleryAlbum)
                    'mediable_type' => GalleryAlbum::class, // Namespace dari model yang berelasi
                ]);
                $media->save(); // Simpan model media

                // Jika Anda menggunakan relasi morphMany dari GalleryAlbum ke Media (yang lebih disarankan)
                // Anda bisa menggunakan: $album->mediaMorph()->save($media);
                // Tapi karena sudah ada gallery_album_id, kita bisa langsung save $media
            }
        }

        return redirect()->route('admin.gallery-albums.show', $album->id)->with('success', 'Media berhasil diunggah!');
    }
    /**
     * Hapus media tertentu dari album.
     */
    public function deleteMedia(GalleryAlbum $album, Media $media)
    {
        // Pastikan media ini memang milik album yang benar
        if ($media->gallery_album_id !== $album->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file fisik
        if (Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }
        if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();

        return redirect()->route('admin.gallery-albums.show', $album->id)->with('success', 'Media berhasil dihapus dari album!');
    }
}
