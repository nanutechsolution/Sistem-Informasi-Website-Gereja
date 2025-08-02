@extends('layouts.app')

@section('title', '| Acara Gereja')

@section('content')
    <div class="container mx-auto px-4 py-8" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="text-4xl font-bold text-center mb-10">Acara Gereja Mendatang & Terkini</h1>
        @if ($events->isEmpty())
            <p class="text-center text-gray-600">Belum ada acara gereja yang dipublikasikan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                        @if ($event->image)
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $event->image) }}"
                                alt="{{ $event->title }}">
                        @else
                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $event->title }}</h3>
                            <p class="text-gray-600 text-sm mb-1"><strong class="font-medium">Lokasi:</strong>
                                {{ $event->location ?? 'Gereja' }}</p>
                            <p class="text-gray-600 text-sm mb-3"><strong class="font-medium">Waktu:</strong>
                                {{ $event->start_time->format('d M Y, H:i') }} @if ($event->end_time)
                                    - {{ $event->end_time->format('H:i') }}
                                @endif
                            </p>
                            <p class="text-gray-700">{{ Str::limit(strip_tags($event->description), 100) }}</p>
                            <div class="mt-4 text-right">
                                <a href="{{ route('public.events.show', $event->slug) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection
