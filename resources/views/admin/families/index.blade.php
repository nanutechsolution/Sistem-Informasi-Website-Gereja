@extends('layouts.admin.app')

@section('title', '| Manajemen Keluarga Jemaat')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Manajemen Keluarga Jemaat') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-2xl font-extrabold text-gray-800 dark:text-white">Daftar Keluarga</h3>
                        <a href="{{ route('admin.families.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Keluarga Baru
                        </a>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div
                            class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 dark:bg-green-200 dark:text-green-900">
                            <strong>Sukses!</strong> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 dark:bg-red-200 dark:text-red-900">
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <div class="overflow-x-auto rounded-lg border dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Nama Keluarga</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Kepala Keluarga</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Jumlah Anggota</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($families as $family)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $family->family_name ?? $family->headMember->full_name . ' Family' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $family->headMember->full_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $family->members->count() }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right space-x-2">
                                            <a href="{{ route('admin.families.show', $family->id) }}"
                                                class="inline-block text-green-600 hover:text-green-800 dark:hover:text-green-400">Kelola</a>
                                            <a href="{{ route('admin.families.edit', $family->id) }}"
                                                class="inline-block text-blue-600 hover:text-blue-800 dark:hover:text-blue-400">Edit</a>
                                            <form action="{{ route('admin.families.destroy', $family->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Yakin ingin hapus keluarga ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 dark:hover:text-red-400">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                            Belum ada keluarga terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $families->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
