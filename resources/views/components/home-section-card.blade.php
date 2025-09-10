@props(['item', 'type' => 'post', 'index' => 0])

<div class="bg-white rounded-2xl shadow-md overflow-hidden transform hover:scale-[1.02] hover:shadow-xl transition duration-300"
    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

    @if ($type === 'post')
        {{-- CARD POST / PENGUMUMAN --}}
        @if ($item->image)
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="h-48 w-full object-cover">
        @else
            <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                             l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01
                             M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2
                             0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $item->title }}</h3>
            <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($item->content), 100) }}</p>
            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>{{ $item->published_at ? $item->published_at->format('d M Y') : 'N/A' }}</span>
                <a href="{{ route('public.posts.show', $item->slug) }}"
                    class="text-blue-600 hover:text-blue-800 font-medium">Baca Selengkapnya →</a>
            </div>
        </div>
    @elseif ($type === 'event')
        {{-- CARD EVENT --}}
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $item->title }}</h3>
            <p class="text-gray-600 text-sm mb-3"><strong>Lokasi:</strong> {{ $item->location ?? 'Online' }}</p>
            <p class="text-gray-600 text-sm mb-4">
                <strong>Waktu:</strong>
                {{ $item->start_time->format('d M Y, H:i') }}
                @if ($item->end_time)
                    - {{ $item->end_time->format('H:i') }}
                @endif
            </p>
            <p class="text-gray-700 text-sm">{{ Str::limit(strip_tags($item->description), 80) }}</p>
            <div class="mt-4 text-right">
                <a href="{{ route('public.events.show', $item->slug) }}"
                    class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail →</a>
            </div>
        </div>
    @elseif ($type === 'schedule')
        {{-- CARD SCHEDULE --}}
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $item->title }}</h3>
            <p class="text-gray-600 text-sm mb-1"><strong>Tanggal:</strong> {{ $item->date->format('d M Y') }}</p>
            <p class="text-gray-600 text-sm mb-3"><strong>Waktu:</strong>
                {{ \Carbon\Carbon::parse($item->time)->format('H:i') }} WIB</p>
            <p class="text-gray-700 text-sm">{{ Str::limit($item->description, 80) ?? 'Tanpa deskripsi.' }}</p>
            <div class="mt-4 text-right">
                <a href="{{ route('public.schedules.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-medium">Lihat Jadwal →</a>
            </div>
        </div>
    @elseif ($type === 'album')
        {{-- CARD ALBUM / GALERI --}}
        <img src="{{ $item->getImageUrl() }}" alt="{{ $item->name }}" class="h-48 w-full object-cover">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate">{{ $item->name }}</h3>
            <p class="text-gray-600 text-sm">{{ $item->event_date ? $item->event_date->format('d M Y') : 'N/A' }}</p>
            <div class="mt-4 text-right">
                <a href="{{ route('public.gallery.show', $item->id) }}"
                    class="text-blue-600 hover:text-blue-800 font-medium">Lihat Album →</a>
            </div>
        </div>
    @endif

</div>
