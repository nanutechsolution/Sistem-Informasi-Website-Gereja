@extends('layouts.app')

@section('title', '| Album: ' . $album->name)

@section('content')
    <div class="container mx-auto px-4 py-8" data-aos="fade-up" data-aos-duration="1000">
        <a href="{{ route('public.gallery.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Galeri
        </a>

        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $album->name }}</h1>
            <div class="text-gray-600 text-sm mb-6 space-y-1">
                <p><strong>Tanggal Kegiatan:</strong> {{ $album->event_date ? $album->event_date->format('d M Y') : 'N/A' }}
                </p>
                <p><strong>Deskripsi:</strong> {{ $album->description ?? '-' }}</p>
            </div>

            @if ($album->media->isEmpty())
                <p class="text-gray-600 text-center">Album ini belum memiliki media.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
                    @foreach ($album->media as $media)
                        <div class="relative group rounded-lg overflow-hidden shadow-md">
                            @if ($media->type === 'image')
                                <img src="{{ asset('storage/' . $media->path) }}"
                                    alt="{{ $media->caption ?? 'Galeri Foto' }}" class="w-full h-48 object-cover">
                            @elseif ($media->type === 'video')
                                <video controls class="w-full h-48 object-cover">
                                    <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            @endif
                            @if ($media->caption)
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    {{ $media->caption }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
