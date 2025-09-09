@extends('layouts.admin.app')

@section('title', '| Manajemen Berita/Pengumuman')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Berita/Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
                        <h3 class="text-2xl font-bold">Daftar Berita & Pengumuman</h3>

                        <a href="{{ route('admin.posts.create') }}"
                            class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition transform hover:scale-95">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Tambah Postingan Baru</span>
                        </a>
                    </div>


                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                        class="fixed top-5 right-5 z-50">
                        @if (session('success'))
                            <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center justify-between space-x-4"
                                role="alert">
                                <span>{{ session('success') }}</span>
                                <button @click="show = false" class="text-white hover:text-gray-200">&times;</button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center justify-between space-x-4"
                                role="alert">
                                <span>{{ session('error') }}</span>
                                <button @click="show = false" class="text-white hover:text-gray-200">&times;</button>
                            </div>
                        @endif
                    </div>

                    {{-- Tabel Postingan --}}
                    <div class="overflow-x-auto">
                        <div class="space-y-4 md:hidden">

                            @foreach ($posts as $post)
                                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-bold text-lg text-gray-800">
                                            {{ Str::limit($post->title, 50) }}

                                        </h4>
                                        @if ($post->is_published)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Dipublikasikan
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Draft
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><strong>Penulis:</strong> {{ $post->user->name ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="mt-4 flex flex-wrap justify-start gap-3 text-sm font-medium">
                                        <a href="{{ route('admin.posts.edit', $post->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Gambar
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Judul
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Penulis
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status Publikasi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Publikasi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($posts as $post)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($post->image)
                                                    <img src="{{ asset('storage/' . $post->image) }}"
                                                        alt="{{ $post->title }}" class="h-12 w-12 object-cover rounded-md">
                                                @else
                                                    <div
                                                        class="h-12 w-12 bg-gray-200 flex items-center justify-center rounded-md text-gray-500 text-xs">
                                                        No Img</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ Str::limit($post->title, 50) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $post->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($post->is_published)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Dipublikasikan
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Draft
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $post->published_at ? $post->published_at->format('d M Y, H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.posts.edit', $post->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Belum ada berita atau pengumuman yang terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
