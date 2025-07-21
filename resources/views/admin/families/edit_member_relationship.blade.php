@extends('layouts.admin.app')

@section('title', '| Edit Hubungan Anggota')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Hubungan Anggota') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-xl font-bold mb-4">Edit Hubungan untuk {{ $member->full_name }} di Keluarga
                        {{ $family->family_name ?? $family->headMember->full_name . ' Family' }}</h3>

                    <form action="{{ route('admin.families.updateMemberRelationship', [$family->id, $member->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="relationship" class="block text-sm font-medium text-gray-700">Hubungan dengan Kepala
                                Keluarga</label>
                            <select name="relationship" id="relationship"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                                <option value="">-- Pilih Hubungan --</option>
                                @foreach ($relationships as $rel)
                                    <option value="{{ $rel }}"
                                        {{ old('relationship', $pivotData->relationship) == $rel ? 'selected' : '' }}>
                                        {{ $rel }}</option>
                                @endforeach
                            </select>
                            @error('relationship')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.families.show', $family->id) }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Perbarui Hubungan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
