@extends('layouts.admin.app')

@section('title', '| Manajemen Galeri')

@section('content')
    <div>
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                {{ $pksScheduleId ? 'Edit Jadwal PKS' : 'Tambah Jadwal PKS Baru' }}</h1>
        </div>

        <form wire:submit.prevent="savePksSchedule" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="activity_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" id="activity_name" wire:model.defer="activity_name"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('activity_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal <span
                            class="text-red-500">*</span></label>
                    <input type="date" id="date" wire:model.defer="date"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Waktu --}}
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu <span
                            class="text-red-500">*</span></label>
                    <input type="time" id="time" wire:model.defer="time"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="location" wire:model.defer="location"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('location')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Nama Pemimpin --}}
                <div>
                    <label for="leader_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Pemimpin <span class="text-red-500">*</span></label>
                    <input type="text" id="leader_name" wire:model.defer="leader_name"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('leader_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="is_active" class="flex items-center">
                        <input type="checkbox" id="is_active" wire:model.defer="is_active"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-900">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Aktif (Akan ditampilkan di website
                            publik)</span>
                    </label>
                    @error('is_active')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea id="description" wire:model.defer="description" rows="3"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Anggota Terlibat (Contoh: text area, bisa diubah ke multiple select jika ada relasi ke anggota jemaat) --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="involved_members" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Anggota
                        Terlibat (pisahkan dengan koma)</label>
                    <textarea id="involved_members" wire:model.defer="involved_members" rows="2"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Contoh: Bpk. Andi, Ibu Budi, Sdri. Citra</p>
                    @error('involved_members')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-8">
                <a href="{{ route('admin.pks-schedules.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 mr-4">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg wire:loading wire:target="savePksSchedule" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Simpan Jadwal PKS
                </button>
            </div>
        </form>
    </div>


@endsection
