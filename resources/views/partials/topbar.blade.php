<nav
    class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-nowrap justify-between items-center">
        <!-- Left: Sidebar toggle + Church Name -->
        <div class="flex items-center flex-nowrap gap-3">
            <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 text-gray-600 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:ring-2 focus:ring-gray-100 dark:text-gray-400 dark:hover:text-white">
                <!-- Hamburger icon -->
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <a href="#" class="text-2xl font-semibold whitespace-nowrap dark:text-white">{{ $churchName }}</a>
        </div>

        <!-- Right: Notifications + User Menu -->
        <div class="flex items-center flex-nowrap gap-3">
            <!-- Notifications -->
            <div class="relative">
                <button type="button" data-dropdown-toggle="notification-dropdown"
                    class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 dark:text-gray-400 dark:hover:text-white">
                    <span class="sr-only">View notifications</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                        </path>
                    </svg>
                    @if (auth()->check() && auth()->user()->unreadNotificationsCustom->count() > 0)
                        <span
                            class="absolute inline-flex items-center justify-center w-3 h-3 text-xs font-bold text-white bg-red-500 rounded-full -top-1 -right-1">
                            {{ auth()->user()->unreadNotificationsCustom->count() }}
                        </span>
                    @endif
                </button>
                <!-- Notification Dropdown -->
                <div id="notification-dropdown"
                    class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 rounded-xl shadow-lg divide-y divide-gray-100 dark:divide-gray-600 z-50">
                    <div
                        class="text-center py-2 font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-600 rounded-t-xl">
                        Notifications
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @if (auth()->check() && auth()->user()->unreadNotificationsCustom->isNotEmpty())
                            @foreach (auth()->user()->unreadNotificationsCustom->take(5) as $notification)
                                <a href="{{ $notification->link ?? route('admin.notifications.index') }}"
                                    class="flex py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $notification->is_read ? 'opacity-75' : 'bg-blue-50 dark:bg-gray-600' }}">
                                    <div class="flex-shrink-0">
                                        <img class="w-10 h-10 rounded-full"
                                            src="{{ Storage::url(Auth::user()->profile_photo_path) ?? 'https://via.placeholder.com/150' }}"
                                            alt="User Avatar" />
                                    </div>
                                    <div class="ml-3 w-full">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $notification->title }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ Str::limit($notification->message, 80) }}</p>
                                        <p class="text-xs font-medium text-blue-600 dark:text-blue-500">
                                            {{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center text-gray-500 dark:text-gray-400 py-3">Tidak ada notifikasi baru.
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('admin.notifications.index') }}"
                        class="block text-center py-2 text-sm text-gray-900 dark:text-white hover:underline bg-gray-50 dark:bg-gray-600 rounded-b-xl">
                        View All
                    </a>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative">
                <button type="button" id="user-menu-button" data-dropdown-toggle="dropdown"
                    class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full"
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                        alt="user photo" />
                </button>
                <div id="dropdown"
                    class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-700 rounded-xl shadow-lg divide-y divide-gray-100 dark:divide-gray-600 z-50">
                    <div class="py-3 px-4">
                        <span
                            class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                        <span
                            class="block text-sm text-gray-500 dark:text-gray-300 truncate">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-1 text-gray-700 dark:text-gray-300">
                        <li><a href="{{ route('profile.edit') }}"
                                class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profil
                                Saya</a></li>
                        <li><a href="#"
                                class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pengaturan
                                Akun</a></li>
                    </ul>
                    <ul class="py-1 text-gray-700 dark:text-gray-300">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Tambahkan Alpine.js atau JS untuk toggle dropdown -->
<script>
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        const target = document.getElementById(button.dataset.dropdownToggle);
        button.addEventListener('click', () => {
            target.classList.toggle('hidden');
        });
    });
</script>
