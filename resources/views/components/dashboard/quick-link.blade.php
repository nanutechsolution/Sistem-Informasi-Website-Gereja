@props(['route', 'color' => 'blue', 'title', 'icon' => 'plus'])

<a href="{{ route($route) }}"
    class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5 flex flex-col items-center text-center hover:ring-2 hover:ring-{{ $color }}-400 transition-all">

    @if ($icon === 'plus')
        <svg class="w-10 h-10 text-{{ $color }}-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
    @elseif ($icon === 'users')
        <svg class="w-10 h-10 text-{{ $color }}-600 mb-2" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h-1.5a4 4 0 00-7 0H7a2 2 0 01-2-2v-2a4 4 0 014-4h6a4 4 0 014 4v2a2 2 0 01-2 2zM12 14a4 4 0 100-8 4 4 0 000 8z" />
        </svg>
    @elseif ($icon === 'report')
        <svg class="w-10 h-10 text-{{ $color }}-600 mb-2" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    @endif

    <span class="font-medium text-lg">{{ $title }}</span>
</a>
