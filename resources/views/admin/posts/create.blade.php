@extends('layouts.admin.app')

@section('title', '| Tambah Berita/Pengumuman Baru')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Berita/Pengumuman Baru') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul
                                Berita/Pengumuman</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Isi
                                Berita/Pengumuman</label>
                            <textarea name="content" id="content" rows="10"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4" x-data="{ imagePreview: null }">
                            <label for="image" class="block text-sm font-medium text-gray-700">
                                Gambar Thumbnail/Banner (Opsional)
                            </label>

                            <input type="file" name="image" id="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 
               file:mr-4 file:py-2 file:px-4 file:rounded-full 
               file:border-0 file:text-sm file:font-semibold 
               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                x-ref="fileInput"
                                @change="imagePreview = $event.target.files.length > 0 ? URL.createObjectURL($event.target.files[0]) : null">

                            <!-- Preview -->
                            <template x-if="imagePreview">
                                <div class="mt-3 relative">
                                    <img :src="imagePreview" class="w-48 h-auto rounded-lg shadow">
                                    <button type="button"
                                        class="absolute top-1 right-1 bg-red-600 text-white text-xs px-2 py-1 rounded opacity-80 hover:opacity-100"
                                        @click="imagePreview = null; $refs.fileInput.value = ''">
                                        Hapus
                                    </button>
                                </div>
                            </template>

                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                {{ old('is_published') ? 'checked' : '' }}>
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
                                Simpan Postingan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
