@extends('layouts.admin.app')

@section('title', '| Manajemen Pengumuman')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            {{ __('Manajemen Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="w-full px-0">

            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Pengumuman</h3>
                        <a href="{{ route('admin.announcements.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Pengumuman
                        </a>
                    </div>

                    {{-- Flash Success --}}
                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-700 border border-green-400 dark:border-green-500 text-green-700 dark:text-white px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Card View --}}
                    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($announcements as $announcement)
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1 p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                            {{ $announcement->title }}
                                        </h3>
                                        <span
                                            class="text-xs font-medium bg-yellow-100 dark:bg-yellow-600 text-yellow-800 dark:text-yellow-100 px-2 py-1 rounded-full">
                                            {{ $announcement->published_at ? $announcement->published_at->diffForHumans() : 'Draft' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Diterbitkan:
                                        {{ $announcement->published_at ? $announcement->published_at->format('d M Y') : 'Belum Dipublikasi' }}
                                    </p>
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                        class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin hapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-sm font-semibold text-red-600 dark:text-red-400 hover:underline inline-flex items-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 dark:text-gray-300">
                                Belum ada pengumuman.
                            </div>
                        @endforelse

                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
