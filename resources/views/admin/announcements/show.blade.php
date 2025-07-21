@extends('layouts.admin.app')

@section('title', '| Detail Pengumuman: ' . $announcement->title)

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">{{ $announcement->title }}</h3>
                        <a href="{{ route('admin.announcements.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Pengumuman
                        </a>
                    </div>

                    <div class="mb-6 text-gray-600 text-sm">
                        <p><strong>Dipublikasikan:</strong>
                            {{ $announcement->published_at ? $announcement->published_at->format('d M Y, H:i') : 'Belum dipublikasi' }}
                        </p>
                        <p><strong>Terakhir Diperbarui:</strong> {{ $announcement->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="prose max-w-none text-gray-800 leading-relaxed mt-4">
                        {!! nl2br(e($announcement->content)) !!} {{-- Menggunakan nl2br dan e() untuk menampilkan line breaks dan mencegah XSS --}}
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mr-2">Edit
                            Pengumuman</a>
                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md">Hapus
                                Pengumuman</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
