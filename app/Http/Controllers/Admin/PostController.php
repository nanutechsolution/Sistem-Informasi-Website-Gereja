<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post; // Pastikan model Post di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login

class PostController extends Controller
{
    /**
     * Tampilkan daftar semua postingan.
     */
    public function index()
    {
        $posts = Post::with('user')->latest('published_at')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Tampilkan form untuk membuat postingan baru.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Simpan postingan baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
                'is_published' => 'boolean', // Checkbox
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('post_images', 'public');
                $validatedData['image'] = $imagePath;
            }

            // Set user_id dari user yang sedang login
            $validatedData['user_id'] = Auth::id();

            // Set is_published (jika checkbox tidak dicentang, nilainya null, jadi set ke false)
            $validatedData['is_published'] = $request->has('is_published');

            Post::create($validatedData);

            return redirect()->route('admin.posts.index')->with('success', 'Berita/Pengumuman berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing Post:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail postingan (opsional).
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Tampilkan form untuk mengedit postingan.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Perbarui postingan di database.
     */
    public function update(Request $request, Post $post)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_published' => 'boolean',
            ]);

            // Handle image upload/update
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($post->image && Storage::disk('public')->exists($post->image)) {
                    Storage::disk('public')->delete($post->image);
                }
                $imagePath = $request->file('image')->store('post_images', 'public');
                $validatedData['image'] = $imagePath;
            } else {
                // Pertahankan gambar lama jika tidak ada gambar baru diupload
                // Atau jika ada input tersembunyi untuk menghapus gambar
                if ($request->input('clear_image')) { // Tambahkan input hidden ini di form jika ingin fitur hapus gambar
                    if ($post->image && Storage::disk('public')->exists($post->image)) {
                        Storage::disk('public')->delete($post->image);
                    }
                    $validatedData['image'] = null;
                } else {
                    $validatedData['image'] = $post->image;
                }
            }

            // Set is_published
            $validatedData['is_published'] = $request->has('is_published');

            $post->update($validatedData);

            return redirect()->route('admin.posts.index')->with('success', 'Berita/Pengumuman berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating Post:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus postingan dari database.
     */
    public function destroy(Post $post)
    {
        try {
            // Hapus gambar terkait jika ada
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
            return redirect()->route('admin.posts.index')->with('success', 'Berita/Pengumuman berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Post:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}