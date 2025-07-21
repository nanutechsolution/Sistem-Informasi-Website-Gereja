@extends('layouts.admin.app')

@section('title', '| Kelola Anggota Pelayanan: ' . $ministry->name)

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Anggota Pelayanan:') }} {{ $ministry->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Detail Pelayanan: {{ $ministry->name }}</h3>
                        <a href="{{ route('admin.ministries.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Pelayanan
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

                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-3">Informasi Pelayanan</h4>
                        <p><strong>Nama:</strong> {{ $ministry->name }}</p>
                        <p><strong>Deskripsi:</strong> {{ $ministry->description ?? '-' }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('admin.ministries.edit', $ministry->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-sm">Edit
                                Pelayanan</a>
                        </div>
                    </div>

                    <hr class="my-8">

                    <h4 class="text-xl font-semibold mb-3">Tambahkan Anggota ke Pelayanan Ini</h4>
                    @if ($availableMembers->isEmpty())
                        <p class="text-gray-600 mb-4">Semua anggota sudah tergabung dalam pelayanan ini, atau belum ada
                            anggota jemaat yang terdaftar.</p>
                    @else
                        <form action="{{ route('admin.ministries.addMember', $ministry->id) }}" method="POST"
                            class="mb-8 p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                            @csrf
                            <div class="mb-4">
                                <label for="member_id" class="block text-sm font-medium text-gray-700">Pilih Anggota
                                    Jemaat</label>
                                <select name="member_id" id="member_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach ($availableMembers as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->full_name }}
                                            ({{ $member->email ?? ($member->phone_number ?? 'No Contact') }})</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Peran dalam
                                        Pelayanan (Opsional, misal: Koordinator, Anggota)</label>
                                    <input type="text" name="role" id="role"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        value="{{ old('role') }}">
                                    @error('role')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="joined_date" class="block text-sm font-medium text-gray-700">Tanggal
                                        Bergabung (Opsional)</label>
                                    <input type="date" name="joined_date" id="joined_date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        value="{{ old('joined_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    @error('joined_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">
                                Tambahkan Anggota
                            </button>
                        </form>
                    @endif

                    <hr class="my-8">

                    <h4 class="text-xl font-semibold mb-3">Anggota dalam Pelayanan Ini (Total:
                        {{ $ministry->members->count() }})</h4>
                    @if ($ministry->members->isEmpty())
                        <p class="text-gray-600">Belum ada anggota dalam pelayanan ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Anggota
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Peran
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Bergabung
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($ministry->members as $member)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $member->full_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $member->pivot->role ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $member->pivot->joined_date ? \Carbon\Carbon::parse($member->pivot->joined_date)->format('d M Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.ministries.editMemberRole', [$ministry->id, $member->id]) }}"
                                                    class="text-blue-600 hover:text-blue-900 mr-3">Edit Peran</a>
                                                <form
                                                    action="{{ route('admin.ministries.removeMember', [$ministry->id, $member->id]) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini dari pelayanan {{ $ministry->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
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
    </div>
@endsection
