<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - GKS Jemaat Reda Pada @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Load dark mode from localStorage
        function toggleDarkMode() {
            const html = document.documentElement;
            const iconSun = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            }
        }


        // Saat halaman dimuat, set ikon sesuai theme
        document.addEventListener('DOMContentLoaded', () => {
            const iconSun = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');
            const isDark = localStorage.theme === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
                iconMoon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                iconSun.classList.remove('hidden');
            }
        });
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 ">
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        @include('partials.topbar')
        <!-- Sidebar -->
        @include('layouts.admin.sidebar')
        <main class="p-4 md:ml-64 h-auto pt-20 mx-auto">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>
