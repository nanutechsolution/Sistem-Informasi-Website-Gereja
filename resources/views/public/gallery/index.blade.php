@extends('layouts.app')

@section('title', '| Galeri Foto & Video')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-10">Galeri Foto & Video Gereja</h1>
        @if ($albums->isEmpty())
            <p class="text-center text-gray-600">Belum ada album galeri yang dipublikasikan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($albums as $album)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                        @if ($album->cover_image)
                            <img class="h-56 w-full object-cover" src="{{ asset('storage/' . $album->cover_image) }}"
                                alt="{{ $album->name }}">
                        @else
                            <div class="h-56 w-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $album->name }}</h3>
                            <p class="text-gray-600 text-sm">
                                {{ $album->event_date ? $album->event_date->format('d M Y') : 'N/A' }}</p>
                            <p class="text-gray-700 text-sm mt-2">
                                {{ Str::limit($album->description, 60) ?? 'Tanpa deskripsi.' }}</p>
                            <div class="mt-4 text-right">
                                <a href="{{ route('public.gallery.show', $album->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">Lihat Album &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $albums->links() }}
            </div>
        @endif
    </div>
@endsection
