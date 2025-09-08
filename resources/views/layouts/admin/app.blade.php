<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $churchName }} @yield('title')</title>
    <link rel="icon" href="{{ Storage::url($logo_path) }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>
    @livewireStyles
    <script>
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
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 ">

    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        @include('partials.topbar')
        @include('layouts.admin.sidebar')
        <main class="p-4 md:ml-64 h-auto pt-20 mx-auto">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>

</html>
