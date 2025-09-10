@extends('layouts.app')

@section('title', '| Beranda')

@section('content')

    {{-- Modal Pengumuman --}}
    @if ($announcements->isNotEmpty())
        <div x-data="{
            open: false,
            index: 0,
            total: {{ $announcements->count() }},
            items: {{ $announcements->toJson() }},
            key: 'announcement_seen_{{ $announcements->last()->id }}',
            start() {
                setInterval(() => {
                    if (this.open) this.index = (this.index + 1) % this.total
                }, 6000)
            }
        }" x-init="if (!localStorage.getItem(key)) {
            open = true;
            start();
            window.scrollTo({ top: 0, behavior: 'smooth' });
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
    <section
        class="relative h-screen flex items-center justify-center text-white overflow-hidden bg-gradient-to-b from-blue-900 to-blue-800">
        {{-- Background --}}
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('images/cover/cover.jpg') }}" alt="Gereja" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-blue-700/70"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 text-center max-w-3xl px-6" x-data="heroAnimation()">
            @php
                $displayName = $churchName
                    ? str_replace('GKS', 'Gereja Kristen Sumba', $churchName)
                    : 'Gereja Kristen Sumba Jemaat Reda Pada';
            @endphp

            {{-- Typing Effect --}}
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 text-yellow-400">
                Selamat Datang di
                <br>
                <span x-text="typedText" class="inline-block"></span>
                <span class="blinking-cursor">|</span>
            </h1>

            {{-- Motto --}}
            <p class="text-lg md:text-xl mb-8 opacity-90" x-show="showMotto" x-transition.duration.1000ms>
                {{ $churchSettings->motto ?? 'Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan.' }}
            </p>

            {{-- Buttons --}}
            <div class="flex flex-wrap justify-center gap-4" x-show="showButtons" x-transition.duration.1000ms>
                <a href="{{ route('public.about') }}"
                    class="bg-yellow-400 text-blue-900 font-semibold py-3 px-8 rounded-full shadow hover:scale-105 hover:shadow-lg transition transform motion-safe:animate-bounce">
                    Tentang Kami
                </a>
                <a href="{{ route('public.contact') }}"
                    class="border-2 border-white text-white font-semibold py-3 px-8 rounded-full shadow hover:bg-white hover:text-blue-900 hover:scale-105 transition transform motion-safe:animate-bounce">
                    Kontak Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Alpine.js Script --}}
    <script>
        function heroAnimation() {
            return {
                typedText: '',
                fullText: '{{ $displayName }}',
                showMotto: false,
                showButtons: false,
                init() {
                    let i = 0;
                    const speed = 100; // ms per character
                    const type = () => {
                        if (i < this.fullText.length) {
                            this.typedText += this.fullText[i];
                            i++;
                            setTimeout(type, speed);
                        } else {
                            // tampilkan motto & buttons setelah typing selesai
                            this.showMotto = true;
                            setTimeout(() => {
                                this.showButtons = true
                            }, 500);
                        }
                    };
                    type();
                }
            }
        }
    </script>




    {{-- Sections --}}
    @php
        $sections = [
            [
                'title' => 'Berita & Pengumuman Terbaru',
                'items' => $latestPosts,
                'empty' => 'Belum ada berita atau pengumuman terbaru.',
                'viewAll' => route('public.posts.index'),
                'type' => 'post',
            ],
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


    @foreach ($sections as $section)
        @if ($section['type'] === 'album')
            <section class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
                        {{ $section['title'] }}
                    </h2>

                    @if ($section['items']->isEmpty())
                        <p class="text-center text-gray-600">
                            {{ $section['empty'] }}
                        </p>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                            style="column-count: 2; column-gap: 1em;">
                            @foreach ($section['items'] as $item)
                                @php
                                    $image = $item->cover_image
                                        ? asset('storage/' . $item->cover_image)
                                        : (count($galleryImages)
                                            ? asset('images/gallery/' . $galleryImages[array_rand($galleryImages)])
                                            : null);
                                @endphp

                                <div class="rounded-lg overflow-hidden relative group break-inside-avoid-column mb-4">
                                    @if ($image)
                                        <a href="{{ route('public.gallery.show', $item->id) }}" class="block">
                                            <img src="{{ $image }}" alt="{{ $item->name ?? 'Galeri' }}"
                                                class="w-full h-auto object-cover rounded-lg transition-transform duration-500 group-hover:scale-105 lazyload"
                                                loading="lazy">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <span class="text-white font-semibold text-center px-2">
                                                    {{ $item->name ?? 'Galeri' }}
                                                </span>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @else
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
                                class="inline-block 
                           px-6 md:px-12 py-3 md:py-4 
                           min-w-[180px] md:min-w-[220px] 
                           bg-gradient-to-r from-blue-600 to-blue-500 
                           text-white font-semibold 
                           rounded-full shadow-lg 
                           hover:scale-105 hover:brightness-110 
                           transition-all duration-300
                           text-center
                           drop-shadow-lg">
                                Lihat Semua
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    @endforeach

    {{-- Masonry CSS --}}
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

    {{-- AOS Init --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof AOS !== 'undefined') AOS.init({
                once: true
            });
        });
    </script>
@endsection
