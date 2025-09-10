@extends('layouts.app')

@section('title', '| Galeri Foto & Video')

@section('content')
    <div class="container mx-auto px-4 py-12">
        {{-- Header --}}
        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-4" data-aos="fade-down" data-aos-duration="1000">
                Galeri Foto & Video Gereja
            </h1>
            <p class="text-gray-600 text-lg" data-aos="fade-up" data-aos-duration="1200">
                Menyimpan momen-momen penting kami dalam foto & video
            </p>
        </header>

        @if ($albums->isEmpty())
            <p class="text-center text-gray-500 text-lg mt-20" data-aos="fade-up" data-aos-duration="1000">
                Belum ada album galeri yang dipublikasikan.
            </p>
        @else
            {{-- Masonry / Mosaic Layout --}}
            <div class="masonry gap-6">
                @foreach ($albums as $album)
                    <div class="masonry-item bg-white rounded-xl shadow-lg overflow-hidden relative transform transition duration-500 hover:scale-105 hover:shadow-2xl"
                        data-aos="fade-up" data-aos-duration="{{ 800 + $loop->index * 100 }}">

                        {{-- Image dengan overlay --}}
                        <div class="relative overflow-hidden">
                            @if ($album->cover_image)
                                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}"
                                    class="w-full object-cover h-auto transform transition-transform duration-500 ease-out hover:scale-110">
                            @else
                                <div class="h-64 bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            {{-- Overlay --}}
                            <div
                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center text-center text-white p-4">
                                <h3 class="text-xl font-semibold mb-2">{{ $album->name }}</h3>
                                <p class="text-sm mb-2">
                                    {{ $album->event_date ? $album->event_date->format('d M Y') : 'N/A' }}</p>
                                <a href="{{ route('public.gallery.show', $album->id) }}"
                                    class="px-4 py-2 bg-blue-600 rounded-full hover:bg-blue-700 transition">Lihat Album</a>
                            </div>
                        </div>

                        {{-- Deskripsi (bisa ditampilkan juga di bawah) --}}
                        <div class="p-4">
                            <p class="text-gray-700 text-sm mt-2">
                                {{ Str::limit($album->description, 70) ?? 'Tanpa deskripsi.' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $albums->links() }}
            </div>
        @endif
    </div>

    {{-- CSS untuk Masonry --}}
    <style>
        .masonry {
            column-count: 4;
            column-gap: 1.5rem;
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
            margin-bottom: 1.5rem;
        }
    </style>

    {{-- Optional: AOS Initialization --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof AOS !== 'undefined') AOS.init({
                once: true
            });
        });
    </script>
@endsection
