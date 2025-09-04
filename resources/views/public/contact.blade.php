@extends('layouts.app')

@section('title', '| Kontak Kami')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl sm:text-5xl font-bold text-center mb-12 text-blue-700" data-aos="fade-down">
            Kontak Kami
        </h1>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 lg:p-12 grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Info Gereja --}}
            <div data-aos="fade-right">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Informasi Gereja</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Alamat:</strong> {{ $alamat }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Telepon:</strong> {{ $telepon }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Email:</strong> {{ $email }}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-4"><strong>Jam Kantor:</strong> Senin - Jumat, 09:00 - 17:00
                    WIB</p>

                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mt-6 mb-4">Media Sosial</h2>
                <div class="flex space-x-4 text-3xl">
                    <a href="{{ $facebook }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition">
                        <i class="fab fa-facebook-square"></i>
                    </a>
                    <a href="{{ $instagram }}" target="_blank" class="text-pink-500 hover:text-pink-700 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $youtube }}" target="_blank" class="text-red-600 hover:text-red-800 transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            {{-- Form Kontak --}}
            <div data-aos="fade-left">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Kirim Pesan</h2>

                @if (session('success'))
                    <div
                        class="bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('public.contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Anda" value="{{ old('name') }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>

                    <input type="email" name="email" placeholder="Email Anda" value="{{ old('email') }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>

                    <textarea name="message_content" placeholder="Pesan Anda" rows="5"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('message_content') }}</textarea>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-md transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>

        </div>

        <h2 class="text-2xl font-semibold mt-8 mb-4">Lokasi Kami</h2>
        <div class="w-full max-w-4xl mx-auto">
            <div class="relative overflow-hidden rounded-md" style="padding-top: 56.25%;"> <!-- 16:9 aspect ratio -->
                {!! $maps_embed !!} {{-- Ambil langsung dari DB --}}
            </div>
        </div>

    </div>

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-pap0K2p2i8Xn4... (full hash) ..." crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
