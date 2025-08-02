@extends('layouts.app')

@section('title', '| Berita & Artikel')

@section('content')
    <div class="container mx-auto px-4 py-8" data-aos="fade-up" data-aos-duration="800">
        <h1 class="text-4xl font-bold text-center mb-10" data-aos="fade-down" data-aos-delay="100">Berita & Artikel Gereja</h1>

        @if ($posts->isEmpty())
            <p class="text-center text-gray-600" data-aos="fade-in" data-aos-delay="200">Belum ada berita atau artikel yang
                dipublikasikan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $index => $post)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105"
                        data-aos="zoom-in-up" data-aos-delay="{{ 100 * $index }}" data-aos-duration="600">
                        @if ($post->image)
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $post->image) }}"
                                alt="{{ $post->title }}">
                        @else
                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 truncate">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $post->published_at ? $post->published_at->format('d M Y') : 'N/A' }}</span>
                                <a href="{{ route('public.posts.show', $post->slug) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">Baca Selengkapnya &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="200">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
