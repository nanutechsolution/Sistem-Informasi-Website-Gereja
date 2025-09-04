<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $churchName }} @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet"> --}}

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col transition-all duration-300 ease-in-out">
        {{-- Navbar --}}
        @include('partials.navbar')

        <!-- Page Heading (Opsional, jika Anda ingin header di halaman publik) -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            {{-- Ini adalah bagian yang akan menerima konten dari @section('content') --}}
            @yield('content')

            {{-- Jika ada konten yang tidak di dalam @section, itu akan masuk ke $slot.
                 Namun, karena kita menggunakan @yield('content'), $slot kemungkinan besar akan kosong.
                 Anda bisa menghapus {{ $slot }} jika yakin tidak akan menggunakannya di public views.
                 Untuk amannya, kita biarkan saja, karena tidak akan menyebabkan error jika kosong. --}}
            {{-- {{ $slot }} --}}
        </main>

        {{-- Footer untuk halaman publik --}}
        @include('partials.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('content-wrapper')?.classList.add('opacity-100');

            const navbar = document.getElementById('main-navbar');
            const isHome = window.location.pathname === '/' || window.location.pathname === '/index';
            if (isHome) {
                // Di halaman home, header disembunyikan sampai scroll
                navbar.classList.add('hidden');
                navbar.classList.remove('opacity-100');

                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        navbar.classList.remove('hidden');
                        navbar.classList.add('opacity-100');
                    } else {
                        navbar.classList.add('hidden');
                        navbar.classList.remove('opacity-100');
                    }
                });
            } else {
                // Di halaman lain, header langsung muncul
                navbar.classList.remove('hidden');
                navbar.classList.add('opacity-100');
            }
        });
    </script>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>

</body>

</html>
