@extends('layouts.app')

@section('title', '| ' . $post->title)

@section('content')
    <div class="container mx-auto px-4 py-8" data-aos="fade-up" data-aos-duration="1000">
        <a href="{{ route('public.posts.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Berita & Artikel
        </a>

        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                    class="w-full h-80 object-cover rounded-lg mb-6">
            @endif
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $post->title }}</h1>
            <div class="text-gray-600 text-sm mb-6 flex items-center space-x-4">
                <span>Oleh: {{ $post->user->name ?? 'Admin' }}</span>
                <span>Pada: {{ $post->published_at ? $post->published_at->format('d M Y, H:i') : 'N/A' }}</span>
            </div>
            <div class="prose max-w-none text-gray-800 leading-relaxed">
                {!! $post->content !!} {{-- Gunakan {!! !!} untuk render HTML dari content --}}
            </div>
        </div>
    </div>
@endsection
