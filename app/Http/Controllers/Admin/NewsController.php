<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News; // Pastikan model News di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Untuk slug
use Illuminate\Support\Facades\Storage; // Untuk upload file

class NewsController extends Controller
{
    /**
     * Tampilkan daftar semua berita.
     */
    public function index()
    {
        // Ambil semua berita, urutkan berdasarkan tanggal publikasi terbaru
        // Eager load user untuk menampilkan nama penulis
        $news = News::with('user')->latest('published_at')->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Tampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Simpan berita baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
                'published_at' => 'nullable|date',
            ]);

            // Generate slug dari judul
            $validatedData['slug'] = Str::slug($validatedData['title']);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('news_images', 'public'); // Simpan di storage/app/public/news_images
                $validatedData['image'] = $imagePath;
            }

            // Set user_id dari user yang sedang login
            $validatedData['user_id'] = auth()->id();

            // Set published_at jika tidak diisi
            if (empty($validatedData['published_at'])) {
                $validatedData['published_at'] = now();
            }

            News::create($validatedData);

            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Tampilkan detail berita (opsional untuk admin).
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Tampilkan form untuk mengedit berita.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Perbarui berita di database.
     */
    public function update(Request $request, News $news)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
                'published_at' => 'nullable|date',
            ]);

            // Generate slug (jika judul berubah)
            if ($request->title !== $news->title) {
                $validatedData['slug'] = Str::slug($validatedData['title']);
            }

            // Handle image upload/update
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($news->image && Storage::disk('public')->exists($news->image)) {
                    Storage::disk('public')->delete($news->image);
                }
                $imagePath = $request->file('image')->store('news_images', 'public');
                $validatedData['image'] = $imagePath;
            } else {
                // Pertahankan gambar lama jika tidak ada gambar baru diupload
                $validatedData['image'] = $news->image;
            }

            // Set published_at jika tidak diisi
            if (empty($validatedData['published_at'])) {
                $validatedData['published_at'] = now();
            }


            $news->update($validatedData);

            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Hapus berita dari database.
     */
    public function destroy(News $news)
    {
        // Hapus gambar terkait jika ada
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
