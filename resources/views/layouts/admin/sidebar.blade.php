<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    <svg aria-hidden="true"
                        class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">Overview</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications.index') }}"
                    class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.notifications.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z">
                        </path>
                        <path
                            d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
                        </path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Pesan Masuk</span>
                    @if (auth()->check() && auth()->user()->unreadNotificationsCustom->count() > 0)
                        <span
                            class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-primary-800 bg-primary-100 dark:bg-primary-200 dark:text-primary-800">
                            {{ auth()->user()->unreadNotificationsCustom->count() }}
                        </span>
                    @endif
                </a>
            </li>
            @php
                $kontenMenu = [
                    [
                        'route' => 'admin.announcements.index',
                        'label' => 'Pengumuman',
                        'pattern' => 'admin/announcements*',
                    ],
                    ['route' => 'admin.schedules.index', 'label' => 'Jadwal Ibadah', 'pattern' => 'admin/schedules*'],
                    [
                        'route' => 'admin.posts.index',
                        'label' => 'Manajemen Berita/Pengumuman',
                        'pattern' => 'admin/posts*',
                    ],
                    [
                        'route' => 'admin.gallery-albums.index',
                        'label' => 'Galeri',
                        'pattern' => 'admin/gallery-albums*',
                    ],
                ];
                $isActive = collect($kontenMenu)->contains(fn($item) => request()->is($item['pattern']));
            @endphp

            <li>
                <button type="button"
                    class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group
        {{ $isActive ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Modul Konten</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dropdown-pages" class="{{ $isActive ? 'block' : 'hidden' }} py-2 space-y-2">
                    @foreach ($kontenMenu as $item)
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg
                    {{ request()->is($item['pattern']) ? 'bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            @php
                $jemaatMenu = [
                    ['route' => 'admin.members.index', 'label' => 'Data Jemaat', 'pattern' => 'admin/members*'],
                    [
                        'route' => 'admin.families.index',
                        'label' => 'Manajemen Keluarga',
                        'pattern' => 'admin/families*',
                    ],
                    [
                        'route' => 'admin.pks_schedules.index',
                        'label' => 'Jadwal PKS',
                        'pattern' => 'admin/pks_schedules*',
                    ],
                    ['route' => 'admin.ministries.index', 'label' => 'Pelayanan', 'pattern' => 'admin/ministries*'],
                    ['route' => 'admin.events.index', 'label' => 'Acara Lainnya', 'pattern' => 'admin/events*'],
                ];

                // cek jika salah satu submenu aktif (wildcard)
                $isActive = collect($jemaatMenu)->contains(fn($item) => request()->is($item['pattern']));
            @endphp

            <li>
                <button type="button"
                    class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group
        {{ $isActive ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    aria-controls="dropdown-jemaat" data-collapse-toggle="dropdown-jemaat">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 0114 0H3z" />
                    </svg>

                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Jemaat & Pelayanan</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dropdown-jemaat" class="{{ $isActive ? 'block' : 'hidden' }} py-2 space-y-2">
                    @foreach ($jemaatMenu as $item)
                        @php
                            $isItemActive = request()->is($item['pattern']);
                        @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg
                    {{ $isItemActive ? 'bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>


            @php
                $keuanganMenu = [
                    ['route' => 'admin.incomes.index', 'label' => 'Pemasukan'],
                    ['route' => 'admin.income-categories.index', 'label' => 'Kategori Pemasukan'],
                    ['route' => 'admin.expenses.index', 'label' => 'Pengeluaran'],
                    ['route' => 'admin.expense-categories.index', 'label' => 'Kategori Pengeluaran'],
                    [
                        'route' => 'admin.auction-transactions.report',
                        'label' => 'Laporan Pembayaran Mingguan',
                    ],
                    [
                        'route' => 'admin.financial-report',
                        'label' => 'Laporan Mingguan',
                    ],
                    ['route' => 'admin.finances.reports', 'label' => 'Laporan Keuangan'],
                ];

                // cek jika salah satu route resource aktif (wildcard)
                $isActive = collect($keuanganMenu)->contains(function ($item) {
                    return request()->routeIs(str_replace('.index', '.*', $item['route']));
                });
            @endphp

            <li>
                <button type="button"
                    class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group
        {{ $isActive ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    aria-controls="dropdown-authentication" data-collapse-toggle="dropdown-authentication">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0 0c1.657 0 3-1.343 3-3s-1.343-3-3-3m0 6v2m0-8v2m9 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Keuangan</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-authentication" class="{{ $isActive ? 'block' : 'hidden' }} py-2 space-y-2">
                    @foreach ($keuanganMenu as $item)
                        @php
                            $isItemActive = request()->routeIs(str_replace('.index', '.*', $item['route']));
                        @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg
                {{ $isItemActive ? 'bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            @php
                $LelangMenu = [
                    [
                        'route' => 'admin.auction_items.index',
                        'label' => 'Barang',
                    ],
                    [
                        'route' => 'admin.auction-transactions.index',
                        'label' => 'Transaksi Lelang',
                    ],
                ];

                // cek jika salah satu route resource aktif (wildcard)
                $isActivea = collect($LelangMenu)->contains(function ($item) {
                    return request()->routeIs(str_replace('.index', '.*', $item['route']));
                });
            @endphp

            <li>
                <button type="button"
                    class="flex items-center p-2 w-full text-base font-medium rounded-lg transition duration-75 group
        {{ $isActivea ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    aria-controls="dropdown-authentications" data-collapse-toggle="dropdown-authentications">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0 0c1.657 0 3-1.343 3-3s-1.343-3-3-3m0 6v2m0-8v2m9 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg> --}}
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Manajemen Lelang</span>
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-authentications" class="{{ $isActivea ? 'block' : 'hidden' }} py-2 space-y-2">
                    @foreach ($LelangMenu as $item)
                        @php
                            $isItemActivea = request()->routeIs(str_replace('.index', '.*', $item['route']));
                        @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium rounded-lg
                {{ $isItemActivea ? 'bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        @php
            $menuItems = [
                [
                    'route' => 'admin.users.index',
                    'label' => 'Manajemen Pengguna',
                    'icon' => '  <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z">
                </path>
            </svg>',
                ],
                [
                    'route' => 'admin.settings.edit',
                    'label' => 'Pengaturan Sistem',
                    'icon' => ' <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                    clip-rule="evenodd"></path>
            </svg>',
                ],
            ];
        @endphp

        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
            @foreach ($menuItems as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                        class="{{ request()->routeIs(str_replace('.', '.*', $item['route'])) ? 'bg-gray-100 dark:bg-gray-700' : '' }}
                      flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        {!! $item['icon'] !!}
                        <span class="ml-3">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
