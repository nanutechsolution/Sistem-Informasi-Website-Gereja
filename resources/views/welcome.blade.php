@extends('layouts.app')

@section('title', '| Beranda')
@section('content')
    <section class="relative h-screen  bg-gradient-to-r from-blue-700 to-blue-900 text-white overflow-hidden"
        data-aos-offset="0">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/cover/cover.jpg') }}" alt="Gereja" class="w-full h-full object-cover opacity-50">
        </div>
        <div
            class="relative z-10 flex items-center justify-center h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div>
                @php
                    $displayName = $churchName
                        ? str_replace('GKS', 'Gereja Kristen Sumba', $churchName)
                        : 'Gereja Kristen Sumba Jemaat Reda Pada';
                @endphp

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4" data-aos="fade-up">
                    Selamat Datang di <br>
                    <span class="text-yellow-300">{{ $displayName }}</span>
                </h1>
                <p class="text-lg sm:text-xl mb-8 opacity-90" data-aos="fade-up" data-aos-delay="200">
                    {{ $churchSettings->motto ?? 'Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan.' }}
                </p>

                <div class="space-x-4" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('public.about') }}"
                        class="inline-block bg-yellow-400 text-blue-900 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-yellow-500 transition duration-300 ease-in-out transform hover:scale-105">
                        Tentang Kami
                    </a>
                    <a href="{{ route('public.contact') }}"
                        class="inline-block bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-white hover:text-blue-900 transition duration-300 ease-in-out transform hover:scale-105">
                        Kontak Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Berita & Pengumuman --}}
    <section class="py-16 bg-gray-50" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-10" data-aos="fade-up">Berita & Pengumuman
                Terbaru</h2>
            @if ($latestPosts->isEmpty())
                <p class="text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">Belum ada berita atau
                    pengumuman terbaru.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($latestPosts as $post)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if ($post->image)
                                <img class="h-48 w-full object-cover" src="{{ Storage::url($post->image) }}"
                                    alt="{{ $post->title }}">
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
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $post->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'N/A' }}</span>
                                    <a href="{{ route('public.posts.show', $post->slug) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">Baca Selengkapnya &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-10" data-aos="zoom-in">
                    <a href="{{ route('public.posts.index') }}"
                        class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">Lihat
                        Semua Berita</a>
                </div>
            @endif
        </div>
    </section>

    {{-- Acara Mendatang --}}
    <section class="py-16 bg-white" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-10" data-aos="fade-up">Acara Mendatang</h2>
            @if ($upcomingEvents->isEmpty())
                <p class="text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">Tidak ada acara mendatang yang
                    terdaftar.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($upcomingEvents as $index => $event)
                        <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:shadow-lg"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $event->title }}</h3>
                                <p class="text-gray-600 text-sm mb-3"><strong class="font-medium">Lokasi:</strong>
                                    {{ $event->location ?? 'Online' }}</p>
                                <p class="text-gray-600 text-sm mb-4"><strong class="font-medium">Waktu:</strong>
                                    {{ $event->start_time->format('d M Y, H:i') }}
                                    @if ($event->end_time)
                                        - {{ $event->end_time->format('H:i') }}
                                    @endif
                                </p>
                                <p class="text-gray-700">{{ Str::limit(strip_tags($event->description), 80) }}</p>
                                <div class="mt-4 text-right">
                                    <a href="{{ route('public.events.show', $event->slug) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10" data-aos="zoom-in">
                    <a href="{{ route('public.events.index') }}"
                        class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">Lihat
                        Semua Acara</a>
                </div>
            @endif
        </div>
    </section>

    {{-- Jadwal Ibadah --}}
    <section class="py-16 bg-gray-50" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-10" data-aos="fade-up">Jadwal Ibadah Rutin</h2>
            @if ($upcomingSchedules->isEmpty())
                <p class="text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">Tidak ada jadwal ibadah
                    mendatang yang terdaftar.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($upcomingSchedules as $index => $schedule)
                        <div class="bg-white rounded-lg shadow-md p-6 transform transition duration-300 hover:shadow-lg"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $schedule->title }}</h3>
                            <p class="text-gray-600 text-sm mb-1"><strong class="font-medium">Tanggal:</strong>
                                {{ $schedule->date->format('d M Y') }}</p>
                            <p class="text-gray-600 text-sm mb-3"><strong class="font-medium">Waktu:</strong>
                                {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</p>
                            <p class="text-gray-700">{{ Str::limit($schedule->description, 80) ?? 'Tanpa deskripsi.' }}</p>
                            <div class="mt-4 text-right">
                                <a href="{{ route('public.schedules.index') }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail Jadwal &rarr;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10" data-aos="zoom-in">
                    <a href="{{ route('public.schedules.index') }}"
                        class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">Lihat
                        Semua Jadwal</a>
                </div>
            @endif
        </div>
    </section>

    {{-- Galeri Terbaru --}}
    <section class="py-16 bg-white" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-10" data-aos="fade-up">Galeri Terbaru</h2>
            @if ($latestAlbums->isEmpty())
                <p class="text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">Belum ada album galeri
                    terbaru.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($latestAlbums as $index => $album)
                        <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:shadow-lg"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <img class="h-48 w-full object-cover" src="{{ $album->getImageUrl() }}"
                                alt="{{ $album->name }}">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate">{{ $album->name }}</h3>
                                <p class="text-gray-600 text-sm">
                                    {{ $album->event_date ? $album->event_date->format('d M Y') : 'N/A' }}</p>
                                <div class="mt-3 text-right">
                                    <a href="{{ route('public.gallery.show', $album->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">Lihat Album &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-10" data-aos="zoom-in">
                    <a href="{{ route('public.gallery.index') }}"
                        class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">Lihat
                        Semua Galeri</a>
                </div>
            @endif
        </div>
    </section>

@endsection
