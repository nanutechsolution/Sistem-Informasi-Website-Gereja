@extends('layouts.admin.app')

@section('title', '| Edit Berita/Pengumuman: ' . $post->title)

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Berita/Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul
                                Berita/Pengumuman</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Isi
                                Berita/Pengumuman</label>
                            <textarea name="content" id="content" rows="10"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Gambar Thumbnail/Banner
                                (Opsional)</label>
                            @if ($post->image)
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-600">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                        class="h-32 w-32 object-cover rounded-md mt-1">
                                    <div class="mt-2 flex items-center">
                                        <input type="checkbox" name="clear_image" id="clear_image" value="1"
                                            class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                        <label for="clear_image" class="ml-2 text-sm text-gray-700">Hapus Gambar Ini</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="image" id="image"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                            <label for="is_published" class="ml-2 block text-sm font-medium text-gray-700">Publikasikan
                                Sekarang</label>
                            @error('is_published')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.posts.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Perbarui Postingan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
