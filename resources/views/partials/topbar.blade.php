     <nav
         class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
         <div class="flex flex-wrap justify-between items-center">
             <div class="flex justify-start items-center">
                 <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                     aria-controls="drawer-navigation"
                     class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                     <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd"
                             d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                             clip-rule="evenodd"></path>
                     </svg>
                     <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd"
                             d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                             clip-rule="evenodd"></path>
                     </svg>
                     <span class="sr-only">Toggle sidebar</span>
                 </button>
                 <a href="#" class="flex items-center justify-between mr-4">
                     <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white">
                         {{ $churchName }}
                     </span>
                 </a>
             </div>
             <div class="flex items-center lg:order-2">
                 <!-- Notifications -->
                 <button x-data="{ open: false }" type ="button" data-dropdown-toggle="notification-dropdown"
                     class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                     <span class="sr-only">View notifications</span>
                     <!-- Bell icon -->
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
                 <!-- Dropdown menu -->
                 <div x-show="open"
                     class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
                     id="notification-dropdown">
                     <div
                         class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                         Notifications
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
                                             src="{{ Auth::user()->profile_photo_path ?? 'https://via.placeholder.com/150/0000FF/FFFFFF?text=A' }}"
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
                             <div class="py-3 px-4 text-gray-500 dark:text-gray-400 text-center">Tidak ada notifikasi
                                 baru.</div>
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
                             View all
                         </div>
                     </a>
                 </div>
                 <button type="button" onclick="toggleDarkMode()"
                     class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition">
                     <span class="sr-only">Toggle dark mode</span>
                     <!-- 🌞 Light Mode Icon -->
                     <svg id="icon-sun" class="w-6 h-6 hidden text-gray-600 " fill="currentColor" viewBox="0 0 20 20">
                         <path
                             d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm0 13a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm7-5a1 1 0 100 2h1a1 1 0 100-2h-1zM3 10a1 1 0 100 2H2a1 1 0 100-2h1zm11.657-5.657a1 1 0 011.414 0L17.414 5a1 1 0 01-1.414 1.414L14.243 5.757a1 1 0 010-1.414zM5.757 14.243a1 1 0 011.414 0L8.172 17a1 1 0 01-1.414 1.414L5.757 15.657a1 1 0 010-1.414zm0-8.486a1 1 0 010 1.414L4.343 6.414A1 1 0 015.757 5zM14.243 14.243a1 1 0 010 1.414l1.414 1.414A1 1 0 0114.243 14.243zM10 5a5 5 0 100 10A5 5 0 0010 5z">
                         </path>
                     </svg>

                     <!-- 🌙 Dark Mode Icon -->
                     <svg id="icon-moon" class="w-6 h-6 hidden text-white" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 0010.586 10.586z"
                             clip-rule="evenodd" />
                     </svg>
                 </button>
                 <button type="button"
                     class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                     id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                     <span class="sr-only">Open user menu</span>
                     <img class="w-8 h-8 rounded-full"
                         src="{{ Auth::user()->profile_photo_path ? Storage::url(Auth::user()->profile_photo_path) : 'https://via.placeholder.com/150/0000FF/FFFFFF?text=A' }}"
                         alt="user photo" />

                 </button>

                 <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded-xl divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                     id="dropdown">
                     <!-- Info User -->
                     <div class="py-3 px-4">
                         <span class="block text-sm font-semibold text-gray-900 dark:text-white">
                             {{ Auth::user()->name }}
                         </span>
                         <span class="block text-sm text-gray-900 truncate dark:text-white">
                             {{ Auth::user()->email }}
                         </span>
                     </div>
                     <!-- Menu Atas -->
                     <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                         <li>
                             <a href="{{ route('profile.edit') }}"
                                 class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                                 Profil Saya
                             </a>
                         </li>
                     </ul>

                     <!-- Menu Logout -->
                     <ul class="py-1 text-gray-700 dark:text-gray-300">
                         <li>
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit"
                                     class="w-full text-left block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                     Keluar
                                 </button>
                             </form>
                         </li>
                     </ul>
                 </div>

             </div>
         </div>
     </nav>
     @push('scripts')
         <script>
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
