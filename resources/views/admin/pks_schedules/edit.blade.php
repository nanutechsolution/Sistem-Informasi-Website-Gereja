@extends('layouts.admin.app')

@section('title', '| Edit Jadwal PKS')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Edit Jadwal PKS') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-6 space-y-6">
                    {{-- Judul Form --}}
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Jadwal PKS</h3>

                    {{-- Form --}}
                    <form action="{{ route('admin.pks_schedules.update', $schedule->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        @include('admin.pks_schedules.form', ['schedule' => $schedule])

                        {{-- Tombol aksi --}}
                        <div class="flex justify-end space-x-3 mt-4">
                            <a href="{{ route('admin.pks_schedules.index') }}"
                                class="px-4 py-2 rounded-md bg-gray-500 hover:bg-gray-600 text-white transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-4 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white transition">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
