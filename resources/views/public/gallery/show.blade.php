@extends('layouts.app')

@section('title', '| Album: ' . $album->name)

@section('content')
    <div class="container mx-auto px-4 py-12">
        {{-- Back Link --}}
        <a href="{{ route('public.gallery.index') }}"
            class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-8 transition-colors duration-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Galeri
        </a>

        {{-- Album Info --}}
        <div class="bg-white rounded-2xl shadow-2xl p-6 lg:p-8" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $album->name }}</h1>
            <div class="text-gray-600 text-sm mb-6 space-y-1">
                <p><strong>Tanggal Kegiatan:</strong> {{ $album->event_date ? $album->event_date->format('d M Y') : 'N/A' }}
                </p>
                <p><strong>Deskripsi:</strong> {{ $album->description ?? '-' }}</p>
            </div>

            @if ($album->media->isEmpty())
                <p class="text-gray-600 text-center">Album ini belum memiliki media.</p>
            @else
                {{-- Masonry Grid --}}
                <div class="masonry gap-4 mt-8">
                    @foreach ($album->media as $media)
                        <div class="masonry-item relative group rounded-lg overflow-hidden shadow-lg transform transition duration-500 hover:scale-105"
                            data-aos="fade-up" data-aos-duration="{{ 800 + $loop->index * 100 }}">

                            {{-- Media --}}
                            @if ($media->type === 'image')
                                <img src="{{ asset('storage/' . $media->path) }}"
                                    alt="{{ $media->caption ?? 'Galeri Foto' }}"
                                    class="w-full object-cover h-auto transform transition-transform duration-500 ease-out hover:scale-110">
                            @elseif ($media->type === 'video')
                                <video controls class="w-full object-cover h-auto rounded-lg">
                                    <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            @endif

                            {{-- Caption Overlay --}}
                            @if ($media->caption)
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-sm p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    {{ $media->caption }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- CSS untuk Masonry --}}
    <style>
        .masonry {
            column-count: 4;
            column-gap: 1rem;
        }

        @media (max-width: 1024px) {
            .masonry {
                column-count: 3;
            }
        }

        @media (max-width: 768px) {
            .masonry {
                column-count: 2;
            }
        }

        @media (max-width: 480px) {
            .masonry {
                column-count: 1;
            }
        }

        .masonry-item {
            break-inside: avoid;
            margin-bottom: 1rem;
        }
    </style>

    {{-- AOS Animation Init --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof AOS !== 'undefined') AOS.init({
                once: true
            });
        });
    </script>
@endsection
