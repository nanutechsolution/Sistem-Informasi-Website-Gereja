 <nav
     class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
     <div class="flex items-center justify-between flex-nowrap w-full">
         <!-- Left: Sidebar toggle + Name -->
         <div class="flex items-center gap-2 flex-shrink-0">
             <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                 aria-controls="drawer-navigation"
                 class="p-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                 <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                     <path fill-rule="evenodd"
                         d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                         clip-rule="evenodd"></path>
                 </svg>
             </button>
             <a href="#" class="flex items-center flex-shrink">
                 <span
                     class="self-center text-xl md:text-2xl font-semibold text-gray-900 dark:text-white max-w-[150px] truncate">
                     {{ $churchName }}
                 </span>
             </a>
         </div>

         <!-- Right: Notifications + Avatar -->
         <div class="flex items-center gap-2 md:gap-4 flex-shrink-0">
             <!-- Notifications -->
             <button type="button" data-dropdown-toggle="notification-dropdown"
                 class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 relative">
                 <span class="sr-only">View notifications</span>
                 <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                     <path
                         d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                     </path>
                 </svg>
                 @if (auth()->check() && auth()->user()->unreadNotificationsCustom->count() > 0)
                     <span
                         class="absolute top-0 right-0 w-3 h-3 bg-red-500 border border-white rounded-full text-xs text-white flex items-center justify-center">
                         {{ auth()->user()->unreadNotificationsCustom->count() }}
                     </span>
                 @endif
             </button>

             <!-- Avatar -->
             <button type="button"
                 class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
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
