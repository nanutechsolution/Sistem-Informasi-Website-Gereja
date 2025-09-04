@extends('layouts.app')

@section('title', '| Tentang Kami')

@section('content')
    <div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-16">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16" data-aos="fade-down" data-aos-duration="800">
                <h1 class="text-5xl sm:text-6xl font-extrabold text-blue-900 mb-4">
                    Tentang {{ $churchName }}
                </h1>
                <p class="text-xl sm:text-2xl text-blue-700 opacity-80">
                    Melayani Tuhan dan sesama dengan kasih, iman, dan pengharapan
                </p>
            </div>

            <!-- Content Card -->
            <div class="bg-white shadow-2xl rounded-3xl p-10 lg:p-16 space-y-12">
                <!-- Intro -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                    <p class="text-gray-700 text-lg sm:text-xl leading-relaxed">
                        Selamat datang di <span class="font-semibold">{{ $churchName }}</span>.
                        Kami adalah komunitas iman yang berakar kuat pada nilai-nilai kasih, pelayanan, dan kebersamaan,
                        yang melayani Tuhan dan sesama di tanah Sumba.
                    </p>
                </div>

                <!-- Visi -->
                <div class="space-y-4" data-aos="fade-right" data-aos-delay="200">
                    <h2 class="text-3xl font-bold text-blue-900 border-l-4 border-yellow-400 pl-4">
                        Visi Kami
                    </h2>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        {{ $visi }}
                    </p>
                </div>

                <!-- Misi -->
                <div class="space-y-4" data-aos="fade-left" data-aos-delay="300">
                    <h2 class="text-3xl font-bold text-blue-900 border-l-4 border-yellow-400 pl-4">
                        Misi Kami
                    </h2>
                    <ul class="list-decimal list-inside text-gray-700 text-lg leading-relaxed space-y-2">
                        @foreach (explode("\n", $misi) as $misiItem)
                            <li>{{ $misiItem }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Sejarah Singkat -->
                <div class="space-y-4" data-aos="fade-up" data-aos-delay="400">
                    <h2 class="text-3xl font-bold text-blue-900 border-l-4 border-yellow-400 pl-4">
                        Sejarah Singkat
                    </h2>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        {{ $sejarah_singkat }}
                    </p>
                </div>

                <!-- Ayat Firman -->
                <div class="mt-12 text-center bg-blue-50 rounded-2xl py-10 px-6" data-aos="zoom-in" data-aos-delay="500">
                    <p class="text-2xl sm:text-3xl font-semibold text-blue-800 italic mb-4">
                        "{{ $ayat_firman }}"
                    </p>
                    <p class="text-lg sm:text-xl text-blue-700 font-medium">
                        - {{ $ayat_firman_sumber }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
