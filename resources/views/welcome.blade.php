@extends('layouts.app')

@section('title', '| Beranda')

@section('content')

    {{-- Modal Pengumuman --}}
    @if ($announcements->isNotEmpty())
        <div x-data="{
            open: false,
            index: 0,
            items: {{ $announcements->toJson() }},
            total: {{ $announcements->count() }},
            key: 'announcement_seen_{{ $announcements->last()->id }}',
            start() {
                setInterval(() => {
                    if (this.open) this.index = (this.index + 1) % this.total
                }, 6000)
            }
        }" x-init="if (!localStorage.getItem(key)) {
            open = true;
            start()
        }" x-show="open" x-transition.opacity x-cloak
            class="fixed inset-0 flex items-center justify-center z-50 bg-black/60 backdrop-blur-sm">

            <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-lg relative overflow-hidden">
                <template x-for="(item, i) in items" :key="i">
                    <div x-show="index === i" x-transition.scale>
                        <div class="p-8 text-center">
                            <h2 class="text-2xl font-bold text-blue-700 mb-4" x-text="item.title"></h2>
                            <p class="text-gray-600 leading-relaxed" x-text="item.content"></p>
                        </div>
                    </div>
                </template>

                {{-- Navigasi --}}
                <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t">
                    <button @click="index = (index - 1 + total) % total"
                        class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 transition">←</button>
                    <span class="text-sm text-gray-500" x-text="(index+1) + ' / ' + total"></span>
                    <button @click="index = (index + 1) % total"
                        class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 transition">→</button>
                </div>

                <button @click="open = false; localStorage.setItem(key, true)"
                    class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white rounded-full px-3 py-1 text-sm shadow">
                    ✕
                </button>
            </div>
        </div>
    @endif

    {{-- Hero Section --}}
    <section class="relative h-screen flex items-center justify-center text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/cover/cover.jpg') }}" alt="Gereja" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-blue-700/70"></div>
        </div>

        <div class="relative z-10 text-center max-w-3xl px-6">
            @php
                $displayName = $churchName
                    ? str_replace('GKS', 'Gereja Kristen Sumba', $churchName)
                    : 'Gereja Kristen Sumba Jemaat Reda Pada';
            @endphp

            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 animate-fade-up">
                Selamat Datang di <br>
                <span class="text-yellow-400">{{ $displayName }}</span>
            </h1>
            <p class="text-lg md:text-xl mb-8 opacity-90 animate-fade-up delay-200">
                {{ $churchSettings->motto ?? 'Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan.' }}
            </p>

            <div class="flex flex-wrap justify-center gap-4 animate-fade-up delay-400">
                <a href="{{ route('public.about') }}"
                    class="bg-yellow-400 text-blue-900 font-semibold py-3 px-8 rounded-full shadow hover:scale-105 hover:shadow-lg transition">
                    Tentang Kami
                </a>
                <a href="{{ route('public.contact') }}"
                    class="border-2 border-white text-white font-semibold py-3 px-8 rounded-full shadow hover:bg-white hover:text-blue-900 hover:scale-105 transition">
                    Kontak Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Section Template Component --}}
    @php
        $sections = [
            // [
            //     'title' => 'Berita & Pengumuman Terbaru',
            //     'items' => $latestPosts,
            //     'empty' => 'Belum ada berita atau pengumuman terbaru.',
            //     'viewAll' => route('public.posts.index'),
            //     'type' => 'post',
            // ],
            [
                'title' => 'Acara Mendatang',
                'items' => $upcomingEvents,
                'empty' => 'Tidak ada acara mendatang yang terdaftar.',
                'viewAll' => route('public.events.index'),
                'type' => 'event',
            ],
            [
                'title' => 'Jadwal Ibadah Rutin',
                'items' => $upcomingSchedules,
                'empty' => 'Tidak ada jadwal ibadah mendatang yang terdaftar.',
                'viewAll' => route('public.schedules.index'),
                'type' => 'schedule',
            ],
            [
                'title' => 'Galeri Terbaru',
                'items' => $latestAlbums,
                'empty' => 'Belum ada album galeri terbaru.',
                'viewAll' => route('public.gallery.index'),
                'type' => 'album',
            ],
        ];
    @endphp

    {{-- Berita & Pengumuman --}}
    <section class="py-20 bg-white" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-center mb-12">📰 Berita & Pengumuman Terbaru</h2>

            @if ($latestPosts->isEmpty())
                <p class="text-center text-gray-500">Belum ada berita atau pengumuman terbaru.</p>
            @else
                {{-- Masonry Grid --}}
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach ($latestPosts as $post)
                        <div
                            class="break-inside-avoid relative group overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-300">

                            {{-- Gambar / Placeholder --}}
                            @if ($post->image)
                                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                                    class="w-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="h-56 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                                                           l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01
                                                           M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2
                                                           0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Overlay konten saat hover --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex flex-col justify-end p-6">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $post->title }}</h3>
                                <p class="text-gray-200 text-sm mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                <div class="flex justify-between items-center text-sm text-gray-300">
                                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'N/A' }}</span>
                                    <a href="{{ route('public.posts.show', $post->slug) }}"
                                        class="text-yellow-400 hover:text-yellow-300 font-medium">Baca Selengkapnya →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Lihat Semua --}}
                <div class="text-center mt-14">
                    <a href="{{ route('public.posts.index') }}"
                        class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 hover:scale-105 transition">
                        Semua Berita
                    </a>
                </div>
            @endif
        </div>
    </section>

    @foreach ($sections as $section)
        <section class="py-16 {{ $loop->odd ? 'bg-gray-50' : 'bg-white' }}" data-aos="fade-up">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">{{ $section['title'] }}</h2>

                @if ($section['items']->isEmpty())
                    <p class="text-center text-gray-600">{{ $section['empty'] }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($section['items'] as $index => $item)
                            @include('components.home-section-card', [
                                'item' => $item,
                                'type' => $section['type'],
                                'index' => $index,
                            ])
                        @endforeach
                    </div>

                    <div class="text-center mt-12">
                        <a href="{{ $section['viewAll'] }}"
                            class="bg-blue-600 text-white font-semibold py-3 px-10 rounded-full shadow hover:bg-blue-700 hover:scale-105 transition">
                            Lihat Semua
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endforeach

@endsection
