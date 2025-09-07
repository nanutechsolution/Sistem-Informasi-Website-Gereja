@props(['title', 'color' => 'yellow', 'value' => 0])

<div
    class="bg-{{ $color }}-100 p-6 rounded-lg shadow-lg border-l-4 border-{{ $color }}-500 hover:shadow-xl transition-all">
    <div>
        <h3 class="text-lg font-semibold text-{{ $color }}-800 mb-1">{{ $title }}</h3>
        <p class="text-3xl font-bold text-{{ $color }}-900">
            Rp {{ number_format($value, 0, ',', '.') }}
        </p>
    </div>
</div>
