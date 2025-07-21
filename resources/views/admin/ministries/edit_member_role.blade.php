@extends('layouts.admin.app')

@section('title', '| Edit Peran Anggota')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Peran Anggota') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-xl font-bold mb-4">Edit Peran untuk {{ $member->full_name }} di Pelayanan
                        {{ $ministry->name }}</h3>

                    <form action="{{ route('admin.ministries.updateMemberRole', [$ministry->id, $member->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Peran dalam
                                Pelayanan</label>
                            <input type="text" name="role" id="role"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('role', $pivotData->role ?? '') }}">
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="joined_date" class="block text-sm font-medium text-gray-700">Tanggal
                                Bergabung</label>
                            <input type="date" name="joined_date" id="joined_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('joined_date', $pivotData->joined_date ? \Carbon\Carbon::parse($pivotData->joined_date)->format('Y-m-d') : '') }}">
                            @error('joined_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.ministries.show', $ministry->id) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Perbarui Peran
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
