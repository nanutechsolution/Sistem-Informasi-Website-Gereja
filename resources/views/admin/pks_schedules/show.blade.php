@extends('layouts.admin.app')

@section('title', '| Detail Jadwal PKS')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Jadwal PKS') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Judul --}}
                    <h3 class="text-2xl font-bold mb-6">
                        {{ $schedule->family ? 'PKS dirumah tangga: ' . $schedule->family->family_name : '-' }}
                        </dd>
                    </h3>

                    {{-- Detail Info --}}
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Hari</dt>
                            <dd class="mt-1 text-gray-900">{{ $schedule->day_of_week }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                            <dd class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jam</dt>
                            <dd class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lokasi / Family</dt>
                            <dd class="mt-1 text-gray-900">{{ $schedule->family ? $schedule->family->family_name : '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pemimpin</dt>
                            <dd class="mt-1 text-gray-900">{{ $schedule->leader ? $schedule->leader->name : '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if ($schedule->is_active)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Aktif</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Nonaktif</span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    {{-- Deskripsi / Firman --}}
                    <div class="mt-6">
                        <dt class="text-sm font-medium text-gray-500">Firman Tuhan</dt>
                        <dd class="mt-1 text-gray-900">{{ $schedule->scripture ?: '-' }}</dd>
                    </div>

                    {{-- Anggota Terlibat --}}
                    <div class="mt-6">
                        <dt class="text-sm font-medium text-gray-500">Anggota Terlibat</dt>
                        <dd class="mt-1 text-gray-900">{{ $schedule->involved_members ?: '-' }}</dd>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end mt-8 space-x-2">
                        <a href="{{ route('admin.pks_schedules.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            Kembali
                        </a>
                        <a href="{{ route('admin.pks_schedules.edit', $schedule->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Edit
                        </a>
                        <form action="{{ route('admin.pks_schedules.destroy', $schedule->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
