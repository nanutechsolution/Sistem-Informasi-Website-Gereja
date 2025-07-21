@extends('layouts.admin.app')

@section('title', '| Kelola Media Album: ' . $album->name)

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Media Album:') }} {{ $album->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Detail Album: {{ $album->name }}</h3>
                        <a href="{{ route('admin.gallery-albums.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Album
                        </a>
                    </div>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-3">Informasi Album</h4>
                        <p><strong>Deskripsi:</strong> {{ $album->description ?? '-' }}</p>
                        <p><strong>Tanggal Kegiatan:</strong>
                            {{ $album->event_date ? $album->event_date->format('d M Y') : '-' }}</p>
                        @if ($album->cover_image)
                            <p class="mt-2"><strong>Cover Album:</strong></p>
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Cover Album"
                                class="h-40 w-40 object-cover rounded-md mt-1 border border-gray-200">
                        @endif
                    </div>

                    <hr class="my-8">
                    <h4 class="text-xl font-semibold mb-3">Unggah Media Baru ke Album Ini</h4>
                    <form action="{{ route('admin.gallery.albums.uploadMedia', $album->id) }}" method="POST"
                        enctype="multipart/form-data"
                        class="mb-8 p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                        @csrf
                        <div class="mb-4">
                            <label for="media_files" class="block text-sm font-medium text-gray-700">Pilih File Media
                                (Foto/Video, bisa lebih dari satu)</label>
                            <input type="file" name="media_files[]" id="media_files" multiple
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 20MB per file. Format: JPEG, PNG, JPG,
                                GIF, SVG (gambar); MP4, MOV, OGG, QT (video).</p>
                            @error('media_files.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="media_captions" class="block text-sm font-medium text-gray-700">Teks Keterangan
                                (Opsional, untuk setiap file)</label>
                            <textarea name="media_captions[]" id="media_captions" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Jika mengunggah banyak file, keterangan ini akan
                                diterapkan ke semua file yang diunggah.</p>
                        </div>

                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">
                            Unggah Media
                        </button>
                    </form>

                    <hr class="my-8">

                    <h4 class="text-xl font-semibold mb-3">Media dalam Album Ini (Total: {{ $album->media->count() }})</h4>
                    @if ($album->media->isEmpty())
                        <p class="text-gray-600">Belum ada media dalam album ini.</p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach ($album->media as $mediaItem)
                                <div
                                    class="relative group border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                                    @if ($mediaItem->type === 'image')
                                        <img src="{{ asset('storage/' . $mediaItem->path) }}"
                                            alt="{{ $mediaItem->caption ?? 'Gambar Galeri' }}"
                                            class="w-full h-36 object-cover">
                                    @else
                                        {{-- type === 'video' --}}
                                        <video controls class="w-full h-36 object-cover"
                                            src="{{ asset('storage/' . $mediaItem->path) }}">
                                            Browser Anda tidak mendukung tag video.
                                        </video>
                                    @endif
                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2 text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        {{ Str::limit($mediaItem->caption, 50) ?? 'Tanpa Keterangan' }}
                                    </div>
                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <form
                                            action="{{ route('admin.gallery.albums.deleteMedia', [$album->id, $mediaItem->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus media ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-full text-xs"
                                                title="Hapus Media">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
