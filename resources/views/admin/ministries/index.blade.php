@extends('layouts.admin.app')

@section('title', '| Manajemen Pelayanan')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pelayanan & Komisi Gereja') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Pelayanan</h3>
                        <a href="{{ route('admin.ministries.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Pelayanan
                        </a>
                    </div>

                    {{-- Pesan Sukses/Error --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Tabel Pelayanan --}}
                    <div class="overflow-x-auto">
                        <div class="space-y-4 md:hidden">
                            @forelse ($ministries as $ministry)
                                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-bold text-lg text-gray-800">
                                            {{ $ministry->name }}</h4>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $ministry->members ? 'bg-indigo-100 text-indigo-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ministry->members->count() }} Anggota
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p class="text-gray-500"> {{ Str::limit($ministry->description, 70) ?? '-' }}</p>
                                    </div>
                                    <div class="mt-4 flex flex-wrap justify-start gap-3 text-sm font-medium">
                                        <a href="{{ route('admin.ministries.show', $ministry->id) }}"
                                            class="text-green-600 hover:text-green-900 mr-3">Kelola Anggota</a>
                                        <a href="{{ route('admin.ministries.edit', $ministry->id) }}"
                                            class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <form action="{{ route('admin.ministries.destroy', $ministry->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelayanan ini dan semua keterkaitannya dengan anggota?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>

                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-4">Belum ada komisi.</div>
                            @endforelse
                        </div>
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Pelayanan
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Deskripsi
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Anggota
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($ministries as $ministry)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $ministry->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($ministry->description, 70) ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $ministry->members->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.ministries.show', $ministry->id) }}"
                                                    class="text-green-600 hover:text-green-900 mr-3">Kelola Anggota</a>
                                                <a href="{{ route('admin.ministries.edit', $ministry->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                <form action="{{ route('admin.ministries.destroy', $ministry->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelayanan ini dan semua keterkaitannya dengan anggota?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Belum ada pelayanan atau komisi yang terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $ministries->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
