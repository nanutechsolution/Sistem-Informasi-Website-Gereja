@extends('layouts.admin.app')

@section('title', '| Edit Album Galeri')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Album Galeri') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.gallery-albums.update', $album->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Penting untuk operasi update --}}

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Album</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('name', $album->name) }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi
                                (Opsional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description', $album->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="event_date" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan
                                (Opsional)</label>
                            <input type="date" name="event_date" id="event_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('event_date', $album->event_date ? $album->event_date->format('Y-m-d') : '') }}">
                            @error('event_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cover_image" class="block text-sm font-medium text-gray-700">Gambar Cover Album
                                (Opsional)</label>
                            @if ($album->cover_image)
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-600">Cover saat ini:</p>
                                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}"
                                        class="h-32 w-32 object-cover rounded-md mt-1">
                                </div>
                            @endif
                            <input type="file" name="cover_image" id="cover_image"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah cover.</p>
                            @error('cover_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.gallery-albums.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Perbarui Album
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
