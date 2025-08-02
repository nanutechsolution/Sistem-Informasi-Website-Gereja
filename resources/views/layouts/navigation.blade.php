 <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex justify-between h-16">
             <div class="flex">
                 <!-- Logo -->
                 <div class="shrink-0 flex items-center">
                     <a href="{{ route('dashboard') }}">
                         <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                     </a>
                 </div>
                 <!-- Navigation Links -->
                 <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                     <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                         {{ __('Dashboard') }}
                     </x-nav-link>
                 </div>
             </div>

             <div class="flex items-center space-x-4">
                 <button @click="darkMode = !darkMode"
                     class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none">
                     <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71.71m16.97 0l-.71-.71M4.05 4.05l-.71-.71M21 12h1M2 12H1m3.22 6.78l-.71.71M19.78 4.22l-.71.71" />
                     </svg>
                     <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M12 3c.132 0 .263.003.393.008a9 9 0 108.599 8.599A9.003 9.003 0 0112 3z" />
                     </svg>
                 </button>

                 {{-- Dropdown Notifikasi --}}
                 <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                     <button @click="open = !open" type="button" {{-- Pastikan type="button" di sini --}}
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


                     <!-- Settings Dropdown -->
                     <div class="hidden sm:flex sm:items-center sm:ms-6">
                         <x-dropdown align="right" width="48">
                             <x-slot name="trigger">
                                 <button
                                     class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                     <div>{{ Auth::user()->name }}</div>
                                     <div class="ms-1">
                                         <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                             <path fill-rule="evenodd"
                                                 d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                 clip-rule="evenodd" />
                                         </svg>
                                     </div>
                                 </button>
                             </x-slot>
                             <x-slot name="content">
                                 <x-dropdown-link :href="route('profile.edit')">
                                     {{ __('Profile') }}
                                 </x-dropdown-link>
                                 <form method="POST" action="{{ route('logout') }}">
                                     @csrf
                                     <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault(); this.closest('form').submit();">
                                         {{ __('Log Out') }}
                                     </x-dropdown-link>
                                 </form>
                             </x-slot>
                         </x-dropdown>
                     </div>
                 </div>

                 <!-- Hamburger -->
                 <div class="-me-2 flex items-center sm:hidden">
                     <button @click="open = ! open"
                         class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                         <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                             <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M4 6h16M4 12h16M4 18h16" />
                             <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M6 18L18 6M6 6l12 12" />
                         </svg>
                     </button>
                 </div>
             </div>
         </div>

         <!-- Responsive Navigation Menu -->
         <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
             <div class="pt-2 pb-3 space-y-1">
                 <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                     {{ __('Dashboard') }}
                 </x-responsive-nav-link>
             </div>
             <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                 <div class="px-4">
                     <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                     <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                 </div>
                 <div class="mt-3 space-y-1">
                     <x-responsive-nav-link :href="route('profile.edit')">
                         {{ __('Profile') }}
                     </x-responsive-nav-link>
                     <form method="POST" action="{{ route('logout') }}">
                         @csrf
                         <x-responsive-nav-link :href="route('logout')"
                             onclick="event.preventDefault(); this.closest('form').submit();">
                             {{ __('Log Out') }}
                         </x-responsive-nav-link>
                     </form>
                 </div>
             </div>
         </div>
 </nav>
