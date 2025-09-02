@extends('layouts.admin.app')

@section('title', '| Tambah Jadwal PKS')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal PKS') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-4">Form Jadwal PKS</h3>

                    <form action="{{ route('admin.pks_schedules.store') }}" method="POST">
                        @csrf
                        @include('admin.pks_schedules.form')

                        <div class="flex justify-end mt-4">
                            <a href="{{ route('admin.pks_schedules.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md mr-2">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
