<nav class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center z-40">
    <div class="flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @yield('page_title', 'Dashboard')
        </h2>
    </div>
    <div class="flex items-center ml-auto">
        <div class="flex items-center space-x-4">
            <button class="md:hidden text-blue-800 dark:text-white" onclick="toggleSidebar()">☰</button>
        </div>
        <button onclick="toggleDarkMode()" class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded">
            Toggle 🌙/☀️
        </button>
        {{-- Profile Dropdown --}}
        <div x-data="{ open: false }" class="relative ml-3">
            <div>
                <button @click="open = ! open"
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/150/0000FF/FFFFFF?text=A' }}"
                        alt="{{ Auth::user()->name }}" /> {{-- Ganti dengan foto profil admin --}}
                </button>
            </div>
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                @click.away="open = false" style="display: none;">
                <div class="py-1 bg-white rounded-md">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Kelola Akun
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    {{-- <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a> --}}

                    <div class="border-t border-gray-100"></div>

                    {{-- Authentication --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
