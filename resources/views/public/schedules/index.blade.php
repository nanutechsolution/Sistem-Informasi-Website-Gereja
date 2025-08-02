@extends('layouts.app')

@section('title', '| Jadwal Ibadah')

@section('content')
    <div class="container mx-auto px-4 py-12" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="text-4xl font-extrabold text-center text-accent mb-12 tracking-tight">
            ⛪ Jadwal Ibadah & Acara Rutin
        </h1>

        @if ($schedules->isEmpty())
            <p class="text-center text-gray-500 text-lg italic">
                Belum ada jadwal ibadah atau acara rutin yang terdaftar.
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($schedules as $schedule)
                    <div
                        class="bg-white border border-gray-100 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xl font-semibold text-gray-800">
                                {{ $schedule->title }}
                            </h3>
                            <span class="text-sm bg-blue-100 text-blue-700 font-semibold px-3 py-1 rounded-full">
                                {{ $schedule->date->format('d M') }}
                            </span>
                        </div>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>
                                <i class="far fa-calendar-alt mr-2 text-primary"></i>
                                <strong class="font-medium">Tanggal:</strong>
                                {{ $schedule->date->format('d M Y') }}
                            </p>
                            <p>
                                <i class="far fa-clock mr-2 text-primary"></i>
                                <strong class="font-medium">Waktu:</strong>
                                {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                <strong class="font-medium">Lokasi:</strong>
                                {{ $schedule->location ?? 'Gereja' }}
                            </p>
                        </div>
                        <div class="mt-4 text-gray-700 text-sm leading-relaxed">
                            {!! nl2br(e(Str::limit($schedule->description, 150, '...'))) !!}
                        </div>
                        <div class="mt-5 text-right">
                            <a href="#" class="text-sm font-medium text-blue-600 hover:underline">
                                📄 Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $schedules->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
@endsection
