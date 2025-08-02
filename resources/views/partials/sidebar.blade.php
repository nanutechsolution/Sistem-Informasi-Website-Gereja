<aside id="sidebar"
    class="fixed z-40 top-0 left-0 w-64 bg-blue-800 dark:bg-gray-800 text-white h-full p-4 transform transition-transform duration-300 -translate-x-full md:relative md:translate-x-0">
    <div class="flex items-center justify-center h-20 border-b border-blue-700 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white tracking-wide">
            GKS REDA ADMIN
        </a>
    </div>
    <nav class="flex-grow">
        <ul>
            <li class="mb-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-15 0v5a1 1 0 001 1h3m-11 0h12a2 2 0 002-2v-11a2 2 0 00-2-2H9a2 2 0 00-2 2v11a2 2 0 002 2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('admin.notifications.index') }}"
                    class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-700 font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    Notifikasi
                    @if (auth()->check() && auth()->user()->unreadNotificationsCustom->count() > 0)
                        <span
                            class="ml-auto px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded-full">{{ auth()->user()->unreadNotificationsCustom->count() }}</span>
                    @endif
                </a>
            </li>

            <li class="mb-2">
                <div class="p-3 text-sm font-semibold text-blue-300">Konten Website</div>
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('admin.announcements.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.announcements.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.5m0 0a2.001 2.001 0 01-1.414 1.414L11 21m0-15a2.001 2.001 0 00-1.414-1.414L11 3m-6 6h12a2 2 0 012 2v3a2 2 0 002 2h0m-14-14h.01M17 17H5a2 2 0 00-2 2v3a2 2 0 002 2h12a2 2 0 002-2v-3a2 2 0 00-2-2z">
                                </path>
                            </svg>
                            Pengumuman
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.schedules.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.schedules.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M9 15h.01M15 15h.01M12 18h.01M3 21h18a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Jadwal Ibadah
                        </a>
                    </li>

                    <li class="mb-1">
                        <a href="{{ route('admin.posts.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.posts.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v10m-3 4H7m6-4v2m-6-2v2m0-4h.01M17 12h.01M17 16h.01M17 8h.01M14 12h.01M14 16h.01M14 8h.01">
                                </path>
                            </svg>
                            Manajemen Berita/Pengumuman
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.gallery-albums.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.gallery.albums.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Galeri
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Modul Jemaat & Pelayanan --}}
            <li class="mb-2">
                <div class="p-3 text-sm font-semibold text-blue-300">Jemaat & Pelayanan</div>
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('admin.members.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.members.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h-1.5a4 4 0 00-7 0H7a2 2 0 01-2-2v-2a4 4 0 014-4h6a4 4 0 014 4v2a2 2 0 01-2 2zM12 14a4 4 0 100-8 4 4 0 000 8z">
                                </path>
                            </svg>
                            Data Jemaat
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.families.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.families.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V10zm5-4h8V5a2 2 0 00-2-2H8a2 2 0 00-2 2v1z">
                                </path>
                            </svg>
                            Manajemen Keluarga
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.ministries.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.ministries.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M10 20v-2a2 2 0 012-2h0a2 2 0 012 2v2m-3-13l3 3m0 0l3-3">
                                </path>
                            </svg>
                            Pelayanan
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.events.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M9 15h.01M15 15h.01M12 18h.01M3 21h18a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Acara Lainnya
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Modul Keuangan --}}
            <li class="mb-2">
                <div class="p-3 text-sm font-semibold text-blue-300">Keuangan</div>
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('admin.incomes.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.incomes.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2V15m-6-1V9m-6-9h16a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z">
                                </path>
                            </svg>
                            Pemasukan
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.income-categories.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.income-categories.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 11h.01M7 15h.01M17 12H3a2 2 0 00-2 2v2a2 2 0 002 2h14a2 2 0 002-2v-2a2 2 0 00-2-2zM17 12V5a2 2 0 00-2-2H5a2 2 0 00-2 2v7">
                                </path>
                            </svg>
                            Kategori Pemasukan
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.expenses.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.expenses.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M12 3a2 2 0 00-2 2v2a2 2 0 002 2h0a2 2 0 002-2V5a2 2 0 00-2-2zM3 17h18a2 2 0 012 2v2a2 2 0 01-2 2H3a2 2 0 01-2-2v-2a2 2 0 012-2z">
                                </path>
                            </svg>
                            Pengeluaran
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{ route('admin.finances.reports') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.finances.reports') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-4a3 3 0 00-3-3H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v9a2 2 0 01-2 2h-2a3 3 0 00-3 3v4">
                                </path>
                            </svg>
                            Laporan Keuangan
                        </a>
                    </li>

                    <li class="mb-1">
                        <a href="{{ route('admin.expense-categories.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.expense-categories.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 11h.01M7 15h.01M17 12H3a2 2 0 00-2 2v2a2 2 0 002 2h14a2 2 0 002-2v-2a2 2 0 00-2-2zM17 12V5a2 2 0 00-2-2H5a2 2 0 00-2 2v7">
                                </path>
                            </svg>
                            Kategori Pengeluaran
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Modul Pengaturan --}}
            <li class="mb-2">
                <div class="p-3 text-sm font-semibold text-blue-300">Pengaturan</div>
                <ul>
                    <li class="mb-1">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-700 font-semibold' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h-10a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2zM9 11h6m-3-3v6">
                                </path>
                            </svg>
                            Manajemen Pengguna
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="{{-- route('admin.settings.index') --}}"
                            class="flex items-center p-3 rounded-lg text-white hover:bg-blue-700 transition duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.827 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.827 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.827-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.827-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan Sistem
                        </a>
                    </li>
                </ul>
            </li>


        </ul>
    </nav>
    <div class="mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center p-3 rounded-lg bg-red-600 hover:bg-red-700 text-white transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
