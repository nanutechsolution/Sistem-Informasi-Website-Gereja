<nav id="main-navbar" class="sticky top-0 z-50 bg-white/80 backdrop-blur-sm shadow-md transition-opacity duration-500"
    x-data="{ open: false }" x-transition x-cloak>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="https://flowbite.s3.amazonaws.com/logo.svg" class="mr-3 h-8" alt="Flowbite Logo" />
                    <span
                        class="text-xl font-bold text-gray-800 hover:text-blue-700 transition duration-300">{{ $churchName }}</span>
                </a>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Beranda</a>
                <a href="{{ route('public.about') }}"
                    class="{{ request()->routeIs('public.about') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Tentang
                    Kami</a>
                <a href="{{ route('public.schedules.index') }}"
                    class="{{ request()->routeIs('public.schedules.*') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Jadwal
                    Ibadah</a>
                <a href="{{ route('public.pks_calendar') }}"
                    class="{{ request()->routeIs('public.pks_calendar') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">PKS</a>
                <a href="{{ route('public.posts.index') }}"
                    class="{{ request()->routeIs('public.posts.*') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Berita
                    & Artikel</a>
                <a href="{{ route('public.events.index') }}"
                    class="{{ request()->routeIs('public.events.*') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Acara</a>
                <a href="{{ route('public.gallery.index') }}"
                    class="{{ request()->routeIs('public.gallery.*') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Galeri</a>
                <a href="{{ route('public.contact') }}"
                    class="{{ request()->routeIs('public.contact') ? 'text-blue-700 font-bold' : 'text-gray-600' }} hover:text-blue-700 transition px-3 py-2 rounded-md font-medium">Kontak</a>
            </div>

            <!-- Tombol Hamburger -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Open main menu</span>

                    <!-- Icon Menu -->
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <!-- Icon Close -->
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" x-show="open" x-transition @click.away="open = false">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Beranda</a>
            <a href="{{ route('public.about') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.about') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Tentang
                Kami</a>
            <a href="{{ route('public.schedules.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.schedules.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Jadwal
                Ibadah</a>
            <a href="{{ route('public.pks_calendar') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.pks_calendar') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Kalender
                PKS</a>
            <a href="{{ route('public.posts.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.posts.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Berita
                & Artikel</a>
            <a href="{{ route('public.events.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.events.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Acara</a>
            <a href="{{ route('public.gallery.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.gallery.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Galeri</a>
            <a href="{{ route('public.contact') }}"
                class="block px-3 py-2 rounded-md text-base font-medium
               {{ request()->routeIs('public.contact') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">Kontak</a>
        </div>
    </div>
</nav>

<!-- pastikan ini ada -->
