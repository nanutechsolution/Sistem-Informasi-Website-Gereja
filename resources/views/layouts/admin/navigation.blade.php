<nav class="bg-white dark:bg-gray-800 shadow-sm p-4 flex justify-between items-center z-40">
    <div class="flex items-center">
        <button @click="$store.sidebar.isOpen = true"
            class="md:hidden p-2 mr-3 text-gray-600 dark:text-gray-400 rounded-md focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @yield('page_title', 'Dashboard')
        </h2>
    </div>

    <div class="flex items-center ml-auto">
        {{-- Toggle Dark/Light Mode --}}
        {{-- Menggunakan Alpine.js store 'darkMode' --}}
        <button @click="$store.darkMode.toggle()" type="button"
            class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-600 mr-2">
            {{-- Icon Matahari (Light Mode) --}}
            <svg x-show="!$store.darkMode.enabled" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            {{-- Icon Bulan (Dark Mode) --}}
            <svg x-show="$store.darkMode.enabled" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 4a1 1 0 011 1v1a1 1 0 11-2 0V7a1 1 0 011-1zm-4 7a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4-4a1 1 0 011 1v1a1 1 0 11-2 0V7a1 1 0 011-1zm4-7a7 7 0 00-6.643 10.485 1 1 0 01-.842 1.49l-1 .249A1 1 0 01.993 15.3l.249-1a1 1 0 011.49-.842A7 7 0 0010 3z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>


        {{-- Dropdown Notifikasi --}}
        {{-- Menggunakan Alpine.js x-data untuk mengelola state dropdown --}}
        <div x-data="{ open: false }" class="relative" @click.outside="open = false">
            <button @click="open = !open" type="button"
                class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                <span class="sr-only">View notifications</span>
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                    </path>
                </svg>
                @if (auth()->check() && auth()->user()->unreadNotificationsCustom->count() > 0)
                    <div class="flex absolute -mt-5 ml-6">
                        <span
                            class="relative inline-flex items-center justify-center w-3 h-3 text-xs font-bold text-white bg-red-500 border border-white rounded-full -top-2 -right-2 dark:border-gray-900">
                            {{ auth()->user()->unreadNotificationsCustom->count() }}
                        </span>
                    </div>
                @endif
            </button>

            {{-- Konten Dropdown Notifikasi --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
                style="display: none;"> {{-- style="display: none;" untuk mencegah FOUC --}}
                <div
                    class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                    Notifikasi Terbaru
                </div>
                <div>
                    @if (auth()->check() && auth()->user()->unreadNotificationsCustom->isNotEmpty())
                        @foreach (auth()->user()->unreadNotificationsCustom->take(5) as $notification)
                            {{-- Tampilkan 5 notifikasi belum dibaca --}}
                            <a href="{{ $notification->link ?? route('admin.notifications.index') }}"
                                class="flex py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600
                                      {{ $notification->is_read ? 'opacity-75' : 'bg-blue-50 dark:bg-gray-600' }}"
                                @if (!$notification->is_read) {{-- Saat diklik, tandai sudah dibaca lalu redirect. event.preventDefault() mencegah navigasi langsung --}}
                                   @click.prevent="markNotificationAsReadAndRedirect('{{ $notification->id }}', '{{ $notification->link ?? route('admin.notifications.index') }}')" @endif>
                                {{-- Konten Notifikasi (disesuaikan agar lebih relevan dengan data kita) --}}
                                <div class="flex-shrink-0">
                                    {{-- Anda bisa tambahkan avatar/icon sesuai 'type' notifikasi --}}
                                    <img class="w-10 h-10 rounded-full"
                                        src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/150/0000FF/FFFFFF?text=A' }}"
                                        alt="User Avatar" />
                                    <div
                                        class="flex absolute justify-center items-center ml-5 -mt-5 w-4 h-4 rounded-full border border-white bg-blue-500 dark:border-gray-700">
                                        <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="pl-3 w-full">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        <span
                                            class="font-semibold text-gray-900 dark:text-white">{{ $notification->title }}</span>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                            {{ Str::limit($notification->message, 80) }}</div>
                                    </div>
                                    <div class="text-xs font-medium text-blue-600 dark:text-blue-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="py-3 px-4 text-gray-500 dark:text-gray-400 text-center">Tidak ada notifikasi baru.
                        </div>
                    @endif
                </div>
                <a href="{{ route('admin.notifications.index') }}"
                    class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline">
                    <div class="inline-flex items-center">
                        <svg aria-hidden="true" class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Lihat Semua Notifikasi
                    </div>
                </a>
            </div>
        </div>

        {{-- Profile Dropdown (tetap sama) --}}
        <div x-data="{ open: false }" class="relative ml-3">
            <div>
                <button @click="open = ! open"
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/150/0000FF/FFFFFF?text=A' }}"
                        alt="{{ Auth::user()->name }}" />
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

@push('scripts')
    <script>
        // Alpine.js Store untuk Dark Mode
        document.addEventListener('alpine:init', () => {
            Alpine.store('darkMode', {
                enabled: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                    '(prefers-color-scheme: dark)').matches),

                init() {
                    this.updateHtmlClass();
                    // Listener untuk perubahan preferensi sistem
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                        if (!('theme' in
                                localStorage
                            )) { // Hanya update jika user belum set preferensi manual
                            this.enabled = e.matches;
                            this.updateHtmlClass();
                        }
                    });
                },

                // Toggle mode dan simpan preferensi ke local storage
                toggle() {
                    this.enabled = !this.enabled;
                    localStorage.theme = this.enabled ? 'dark' : 'light';
                    this.updateHtmlClass();
                },

                // Update class 'dark' pada elemen html
                updateHtmlClass() {
                    if (this.enabled) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });

            // Alpine.js Store untuk Sidebar (agar state bisa diakses dari navigation dan sidebar itu sendiri)
            Alpine.store('sidebar', {
                isOpen: false, // Default tertutup di mobile, terbuka di desktop (CSS handle)

                // Metode untuk toggle sidebar
                toggle() {
                    this.isOpen = !this.isOpen;
                },
                // Metode untuk menutup sidebar (misal saat klik di luar)
                close() {
                    this.isOpen = false;
                }
            });
        });

        // Global function untuk toggle dark mode dari HTML (misal dari button di navigation.blade.php)
        function toggleDarkMode() {
            Alpine.store('darkMode').toggle();
        }

        // Fungsi untuk menandai notifikasi sudah dibaca dari dropdown
        function markNotificationAsReadAndRedirect(notificationId, redirectLink) {
            fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect setelah notifikasi ditandai sudah dibaca
                        window.location.href = redirectLink;
                    } else {
                        alert('Gagal menandai notifikasi sebagai sudah dibaca.');
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                    alert('Terjadi kesalahan saat menandai notifikasi.');
                });
        }
    </script>
@endpush
