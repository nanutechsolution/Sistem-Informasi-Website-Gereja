@extends('layouts.app')

@section('title', '| Galeri Foto & Video')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-4" data-aos="fade-down" data-aos-duration="1000">
                Galeri Foto & Video Gereja
            </h1>
            <p class="text-gray-600 text-lg" data-aos="fade-up" data-aos-duration="1200">
                Lihat momen-momen penting kami dalam foto dan video
            </p>
        </header>

        @if ($albums->isEmpty())
            <p class="text-center text-gray-500 text-lg mt-20" data-aos="fade-up" data-aos-duration="1000">
                Belum ada album galeri yang dipublikasikan.
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($albums as $album)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-2xl relative"
                        data-aos="fade-up" data-aos-duration="{{ 800 + $loop->index * 100 }}">

                        {{-- Parallax effect for image --}}
                        <div class="overflow-hidden h-56 relative">
                            @if ($album->cover_image)
                                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}"
                                    class="absolute w-full h-full object-cover transform transition-transform duration-500 ease-out hover:scale-110">
                            @else
                                <div class="h-56 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1 truncate">{{ $album->name }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $album->event_date ? $album->event_date->format('d M Y') : 'N/A' }}</p>
                            <p class="text-gray-700 text-sm mt-2">
                                {{ Str::limit($album->description, 70) ?? 'Tanpa deskripsi.' }}</p>
                            <div class="mt-4 text-right">
                                <a href="{{ route('public.gallery.show', $album->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-300">
                                    Lihat Album &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $albums->links() }}
            </div>
        @endif
    </div>

    {{-- Optional: AOS Initialization --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof AOS !== 'undefined') AOS.init({
                once: true
            });
        });
    </script>
@endsection
