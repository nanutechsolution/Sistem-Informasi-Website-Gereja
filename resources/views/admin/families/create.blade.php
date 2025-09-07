@extends('layouts.admin.app')

@section('title', '| Tambah Keluarga Jemaat Baru')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Keluarga Jemaat Baru') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.families.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="family_name" class="block text-sm font-medium text-gray-700">Nama Keluarga (Opsional,
                                misal: Keluarga Bpk. Yanto)</label>
                            <input type="text" name="family_name" id="family_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('family_name') }}">
                            @error('family_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="head_member_id" class="block text-sm font-medium text-gray-700">Kepala
                                Keluarga</label>
                            <select name="head_member_id" id="head_member_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                                <option value="">-- Pilih Anggota Jemaat --</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('head_member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('head_member_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div x-data="selectComponent()">
                            <input type="text" x-model="search" @input="searchMembers" placeholder="Cari anggota...">
                            <ul x-show="members.length > 0">
                                <template x-for="member in filteredMembers" :key="member.id">
                                    <li @click="selectMember(member)">
                                        <span x-text="member.full_name"></span>
                                    </li>
                                </template>
                            </ul>
                            <input type="hidden" name="head_member_ids"
                                x-bind:value="selectedMember ? selectedMember.id : ''">
                        </div> --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.families.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Simpan Keluarga
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function selectComponent() {
            return {
                search = '',
                members: {!! json_encode($members) !!},
                selectedMember: null,
                filteredMembers: [],
                searchMembers() {
                    this.filteredMembers = this.members.filter(member => {
                        return member.full_name.tolowerCase().include(this.search.tolowerCase())
                    });
                },
                selectedMember(member) {
                    this.selectedMember = member;
                    this.search = member.full_name;
                    this.filteredMembers = [];
                }
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headMemberId = document.getElementById('head_member_id');

            headMemberId.addEventListener('change', function() {
                const selectedOption = headMemberId.options[headMemberId.selectedIndex].text;
                const familyName = 'Keluarga ' + selectedOption.split('()')[0].trim();
                document.getElementById('family_name').value = familyName;
            });

        });
    </script>
@endsection
