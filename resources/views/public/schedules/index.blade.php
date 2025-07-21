@extends('layouts.app')

@section('title', '| Jadwal Ibadah')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-10">Jadwal Ibadah & Acara Rutin</h1>
        @if ($schedules->isEmpty())
            <p class="text-center text-gray-600">Belum ada jadwal ibadah atau acara rutin yang terdaftar.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($schedules as $schedule)
                    <div class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $schedule->title }}</h3>
                        <p class="text-gray-600 text-sm mb-1"><strong class="font-medium">Tanggal:</strong>
                            {{ $schedule->date->format('d M Y') }}</p>
                        <p class="text-gray-600 text-sm mb-3"><strong class="font-medium">Waktu:</strong>
                            {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</p>
                        <p class="text-gray-600 text-sm mb-4"><strong class="font-medium">Lokasi:</strong>
                            {{ $schedule->location ?? 'Gereja' }}</p>
                        <p class="text-gray-700">{{ Str::limit($schedule->description, 120) ?? 'Tanpa deskripsi.' }}</p>
                        <div class="mt-4 text-right">
                            {{-- Jika ada detail lebih lanjut, bisa ditambahkan link --}}
                            <span class="text-blue-600 font-medium">Lihat Detail</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
@endsection
