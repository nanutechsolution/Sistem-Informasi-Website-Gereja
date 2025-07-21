@extends('layouts.admin.app')

@section('title', '| Kelola Keluarga: ' . ($family->family_name ?? $family->headMember->full_name . ' Family'))

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Kelola Keluarga: {{ $family->family_name ?? $family->headMember->full_name . ' Family' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        Detail Keluarga: {{ $family->family_name ?? $family->headMember->full_name . ' Family' }}
                    </h3>
                    <a href="{{ route('admin.families.index') }}"
                        class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                {{-- Alert --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md border border-green-300">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md border border-red-300">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                {{-- Info Keluarga --}}
                <div class="mb-8">
                    <div
                        class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 transition-all duration-300 hover:shadow-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Detail Keluarga</h2>
                            <a href="{{ route('admin.families.edit', $family->id) }}"
                                class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-1.5 px-3 rounded-md transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </a>
                        </div>

                        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex justify-between">
                                <span class="font-medium">Nama Keluarga:</span>
                                <span>{{ $family->family_name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Kepala Keluarga:</span>
                                <span>{{ $family->headMember->full_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Jumlah Anggota:</span>
                                <span>{{ $family->members->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>



                <hr class="my-6 border-gray-300 dark:border-gray-600" />

                {{-- Tambah Anggota --}}
                <div class="mb-8">
                    <h4 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Tambahkan Anggota</h4>
                    @if ($availableMembers->isEmpty())
                        <p class="text-sm text-gray-500">Semua anggota telah tergabung atau belum ada data.</p>
                    @else
                        <form method="POST" action="{{ route('admin.families.addMemberToFamily', $family->id) }}"
                            class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-dashed border-gray-300">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label for="member_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Anggota
                                        Jemaat</label>
                                    <select name="member_id" id="member_id" required
                                        class="w-full p-2.5 border rounded-lg shadow-sm outline-none
         bg-white text-gray-900
         dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:placeholder-gray-400
         focus:ring-2 focus:ring-blue-500 focus:border-blue-500
         dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($availableMembers as $member)
                                            <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="relationship"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Hubungan</label>
                                    <select name="relationship" id="relationship" required
                                        class="w-full p-2.5 border rounded-lg shadow-sm outline-none
                 bg-white text-gray-900
                 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:placeholder-gray-400
                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($relationships as $rel)
                                            <option value="{{ $rel }}">{{ $rel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md">
                                Tambahkan
                            </button>
                        </form>
                    @endif
                </div>

                <hr class="my-6 border-gray-300 dark:border-gray-600" />

                {{-- Tabel Anggota --}}
                <h4 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Anggota Keluarga</h4>
                @if ($family->members->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada anggota keluarga.</p>
                @else
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-600">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-bold">Nama</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold">Hubungan</th>
                                    <th class="px-6 py-3 text-right text-sm font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($family->members as $member)
                                    <tr>
                                        <td class="px-6 py-4 font-medium">
                                            {{ $member->full_name }}
                                            @if ($member->id === $family->head_member_id)
                                                <span
                                                    class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Kepala</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $member->pivot->relationship ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            @if ($member->id !== $family->head_member_id)
                                                <a href="{{ route('admin.families.editMemberRelationship', [$family->id, $member->id]) }}"
                                                    class="text-blue-600 hover:underline">Edit</a>
                                                <form
                                                    action="{{ route('admin.families.removeMemberFromFamily', [$family->id, $member->id]) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Yakin ingin menghapus {{ $member->full_name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:underline">Hapus</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Terkunci</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
