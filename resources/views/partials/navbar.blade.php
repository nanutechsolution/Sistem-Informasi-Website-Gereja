<nav id="main-navbar"
    class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl shadow-md hidden transition-opacity duration-500 opacity-0"
    x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="https://flowbite.s3.amazonaws.com/logo.svg" class="mr-3 h-8" alt="Flowbite Logo" />
                    <span class="text-xl font-bold text-gray-800 hover:text-blue-700 transition duration-300">GKS Jemaat
                        Reda Pada</span>
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('home') ? 'text-blue-700 font-bold' : '' }}">Beranda</a>
                <a href="{{ route('public.about') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('public.about') ? 'text-blue-700 font-bold' : '' }}">Tentang
                    Kami</a>
                <a href="{{ route('public.schedules.index') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('public.schedules.*') ? 'text-blue-700 font-bold' : '' }}">Jadwal
                    Ibadah</a>
                <a href="{{ route('public.posts.index') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('public.posts.*') ? 'text-blue-700 font-bold' : '' }}">Berita
                    & Artikel</a>
                <a href="{{ route('public.events.index') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('public.events.*') ? 'text-blue-700 font-bold' : '' }}">Acara</a>
                <a href="{{ route('public.gallery.index') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('public.gallery.*') ? 'text-blue-700 font-bold' : '' }}">Galeri</a>
                <a href="{{ route('public.contact') }}"
                    class="text-gray-600 hover:text-blue-700 transition duration-300 ease-in-out px-3 py-2 rounded-md font-medium {{ request()->routeIs('public.contact') ? 'text-blue-700 font-bold' : '' }}">Kontak</a>
                {{-- Tombol Login untuk Admin --}}
                {{-- @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full font-medium transition duration-300 ease-in-out">Dashboard
                        Admin</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full font-medium transition duration-300 ease-in-out">Login</a> --}}
                {{-- @endauth --}}
            </div>
            <div class="md:hidden flex items-center">
                {{-- Tombol Hamburger untuk mobile --}}
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu, show/hide based on menu state. --}}
    <div class="md:hidden" x-show="open" @click.away="open = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
        style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
            <a href="{{ route('public.about') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Tentang
                Kami</a>
            <a href="{{ route('public.schedules.index') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Jadwal
                Ibadah</a>
            <a href="{{ route('public.posts.index') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Berita
                & Artikel</a>
            <a href="{{ route('public.events.index') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Acara</a>
            <a href="{{ route('public.gallery.index') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Galeri</a>
            <a href="{{ route('public.contact') }}"
                class="text-gray-700 hover:bg-blue-50 hover:text-blue-700 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
        </div>
    </div>
</nav>
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('main-navbar');
            console.log(navbar);

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.remove('hidden');
                    navbar.classList.add('opacity-100');
                } else {
                    navbar.classList.add('hidden');
                    navbar.classList.remove('opacity-100');
                }
            });
        });
    </script>
@endpush
