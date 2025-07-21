@extends('layouts.app')

@section('title', '| ' . $event->title)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('public.events.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Acara Gereja
        </a>

        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
            @if ($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                    class="w-full h-96 object-cover rounded-lg mb-6">
            @endif
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $event->title }}</h1>
            <div class="text-gray-600 text-sm mb-6 space-y-1">
                <p><strong>Waktu:</strong> {{ $event->start_time->format('d M Y, H:i') }} @if ($event->end_time)
                        - {{ $event->end_time->format('H:i') }}
                    @endif
                </p>
                <p><strong>Lokasi:</strong> {{ $event->location ?? 'Gereja' }}</p>
                <p><strong>Penyelenggara:</strong> {{ $event->organizer ?? 'Gereja' }}</p>
                <p><strong>Status:</strong> <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $event->status == 'scheduled'
                            ? 'bg-blue-100 text-blue-800'
                            : ($event->status == 'completed'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800') }}">{{ ucfirst($event->status) }}</span>
                </p>
            </div>
            <div class="prose max-w-none text-gray-800 leading-relaxed">
                {!! $event->description !!} {{-- Gunakan {!! !!} untuk render HTML --}}
            </div>
        </div>
    </div>
@endsection
