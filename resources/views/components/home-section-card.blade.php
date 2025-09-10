@props(['item', 'type' => 'post', 'index' => 0])

<div class="bg-white rounded-2xl shadow-md overflow-hidden transform hover:scale-[1.02] hover:shadow-xl transition duration-300"
    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

    @if ($type === 'post')
        @if ($item->image)
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="h-48 w-full object-cover">
        @else
            @php
                // ambil semua file di folder 'public/unsplash'
                $files = \Illuminate\Support\Facades\File::files(public_path('images/unsplash'));
                // ambil salah satu file secara acak
                $randomFile = $files[array_rand($files)]->getFilename();
            @endphp
            <img src="{{ asset('images/unsplash/' . $randomFile) }}" alt="{{ $item->title ?? 'Placeholder Image' }}"
                class="h-48 w-full object-cover">
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
    @endif

</div>
