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
        </ul>
        @php
            $menuItems = [
                [
                    'route' => 'admin.auction_items.index',
                    'label' => 'Manajemen Lelang',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-grey-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6h6m-6 0v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h6m6-6a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>',
                ],
                [
                    'route' => 'admin.auction-transactions.index',
                    'label' => 'Manajemen Transaksi Lelang',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-grey-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6h6m-6 0v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h6m6-6a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>',
                ],
                [
                    'route' => 'admin.auction-transactions.report',
                    'label' => 'Laporan Pembayaran Mingguan',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-grey-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6h6m-6 0v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h6m6-6a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>',
                ],
                [
                    'route' => 'admin.financial-report',
                    'label' => 'Laporan Mingguan',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-grey-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6h6m-6 0v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h6m6-6a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>',
                ],
                [
                    'route' => 'admin.users.index',
                    'label' => 'Manajemen Pengguna',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-grey-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6h6m-6 0v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h6m6-6a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>',
                ],
                [
                    'route' => 'admin.settings.edit',
                    'label' => 'Pengaturan Sistem',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>',
                ],
            ];
        @endphp

        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
            @foreach ($menuItems as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                        class="{{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'bg-gray-100 dark:bg-gray-700' : '' }}
                      flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        {!! $item['icon'] !!}
                        <span class="ml-3">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

    </div>
    <div
        class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20">
        <a href="#"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z">
                </path>
            </svg>
        </a>
        <a href="#" data-tooltip-target="tooltip-settings"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
            <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                    clip-rule="evenodd"></path>
            </svg>
        </a>
        <div id="tooltip-settings" role="tooltip"
            class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip">
            Pengaturan Sistem
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
        <button type="button" data-dropdown-toggle="language-dropdown"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:hover:text-white dark:text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
            <svg aria-hidden="true" class="h-5 w-5 rounded-full mt-0.5" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3900 3900">
                <path fill="#b22234" d="M0 0h7410v3900H0z" />
                <path d="M0 450h7410m0 600H0m0 600h7410m0 600H0m0 600h7410m0 600H0" stroke="#fff"
                    stroke-width="300" />
                <path fill="#3c3b6e" d="M0 0h2964v2100H0z" />
                <g fill="#fff">
                    <g id="d">
                        <g id="c">
                            <g id="e">
                                <g id="b">
                                    <path id="a"
                                        d="M247 90l70.534 217.082-184.66-134.164h228.253L176.466 307.082z" />
                                    <use xlink:href="#a" y="420" />
                                    <use xlink:href="#a" y="840" />
                                    <use xlink:href="#a" y="1260" />
                                </g>
                                <use xlink:href="#a" y="1680" />
                            </g>
                            <use xlink:href="#b" x="247" y="210" />
                        </g>
                        <use xlink:href="#c" x="494" />
                    </g>
                    <use xlink:href="#d" x="988" />
                    <use xlink:href="#c" x="1976" />
                    <use xlink:href="#e" x="2470" />
                </g>
            </svg>
        </button>
        <!-- Dropdown -->
        <div class="hidden z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700"
            id="language-dropdown">
            <ul class="py-1" role="none">
                <li>
                    <a href="#"
                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                        role="menuitem">
                        <div class="inline-flex items-center">
                            <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-us" viewBox="0 0 512 512">
                                <g fill-rule="evenodd">
                                    <g stroke-width="1pt">
                                        <path fill="#bd3d44"
                                            d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                            transform="scale(3.9385)" />
                                        <path fill="#fff"
                                            d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z"
                                            transform="scale(3.9385)" />
                                    </g>
                                    <path fill="#192f5d" d="M0 0h98.8v70H0z" transform="scale(3.9385)" />
                                    <path fill="#fff"
                                        d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z"
                                        transform="scale(3.9385)" />
                                </g>
                            </svg>
                            English (US)
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-600"
                        role="menuitem">
                        <div class="inline-flex items-center">
                            <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-de" viewBox="0 0 512 512">
                                <path fill="#ffce00" d="M0 341.3h512V512H0z" />
                                <path d="M0 0h512v170.7H0z" />
                                <path fill="#d00" d="M0 170.7h512v170.6H0z" />
                            </svg>
                            Deutsch
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-600"
                        role="menuitem">
                        <div class="inline-flex items-center">
                            <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-it" viewBox="0 0 512 512">
                                <g fill-rule="evenodd" stroke-width="1pt">
                                    <path fill="#fff" d="M0 0h512v512H0z" />
                                    <path fill="#009246" d="M0 0h170.7v512H0z" />
                                    <path fill="#ce2b37" d="M341.3 0H512v512H341.3z" />
                                </g>
                            </svg>
                            Italiano
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                        role="menuitem">
                        <div class="inline-flex items-center">
                            <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full mr-2"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                id="flag-icon-css-cn" viewBox="0 0 512 512">
                                <defs>
                                    <path id="a" fill="#ffde00" d="M1-.3L-.7.8 0-1 .6.8-1-.3z" />
                                </defs>
                                <path fill="#de2910" d="M0 0h512v512H0z" />
                                <use width="30" height="20" transform="matrix(76.8 0 0 76.8 128 128)"
                                    xlink:href="#a" />
                                <use width="30" height="20" transform="rotate(-121 142.6 -47) scale(25.5827)"
                                    xlink:href="#a" />
                                <use width="30" height="20" transform="rotate(-98.1 198 -82) scale(25.6)"
                                    xlink:href="#a" />
                                <use width="30" height="20" transform="rotate(-74 272.4 -114) scale(25.6137)"
                                    xlink:href="#a" />
                                <use width="30" height="20" transform="matrix(16 -19.968 19.968 16 256 230.4)"
                                    xlink:href="#a" />
                            </svg>
                            中文 (繁體)
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
