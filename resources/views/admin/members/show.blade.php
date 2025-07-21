@extends('layouts.admin.app')

@section('title', '| Detail Anggota Jemaat: ' . $member->full_name)

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Anggota Jemaat') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Detail Anggota: {{ $member->full_name }}</h3>
                        <a href="{{ route('admin.members.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Anggota
                        </a>
                    </div>

                    <div class="mb-6">
                        <p class="mb-2"><strong>Nama Lengkap:</strong> {{ $member->full_name }}</p>
                        <p class="mb-2"><strong>NIK:</strong> {{ $member->nik ?? '-' }}</p>
                        <p class="mb-2"><strong>Jenis Kelamin:</strong> {{ $member->gender ?? '-' }}</p>
                        <p class="mb-2"><strong>Tempat, Tanggal Lahir:</strong> {{ $member->place_of_birth ?? '-' }},
                            {{ $member->date_of_birth ? $member->date_of_birth->format('d M Y') : '-' }}</p>
                        <p class="mb-2"><strong>Golongan Darah:</strong> {{ $member->blood_type ?? '-' }}</p>
                        <p class="mb-2"><strong>Alamat:</strong> {{ $member->address ?? '-' }}</p>
                        <p class="mb-2 pl-4">Kota: {{ $member->city ?? '-' }}</p>
                        <p class="mb-2 pl-4">Provinsi: {{ $member->province ?? '-' }}</p>
                        <p class="mb-2 pl-4">Kode Pos: {{ $member->postal_code ?? '-' }}</p>
                        <p class="mb-2"><strong>Nomor Telepon:</strong> {{ $member->phone_number ?? '-' }}</p>
                        <p class="mb-2"><strong>Email:</strong> {{ $member->email ?? '-' }}</p>
                        <p class="mb-2"><strong>Tanggal Baptis:</strong>
                            {{ $member->baptism_date ? $member->baptism_date->format('d M Y') : '-' }}</p>
                        <p class="mb-2"><strong>Tanggal Sidi:</strong>
                            {{ $member->sidi_date ? $member->sidi_date->format('d M Y') : '-' }}</p>
                        <p class="mb-2"><strong>Status Pernikahan:</strong> {{ $member->marital_status ?? '-' }}</p>
                        <p class="mb-2"><strong>Catatan Internal:</strong> {{ $member->notes ?? '-' }}</p>
                        <p class="mb-2"><strong>Status Keanggotaan:</strong>
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->status == 'Aktif' ? 'bg-green-100 text-green-800' : ($member->status == 'Non-aktif' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $member->status }}
                            </span>
                        </p>
                        <p class="mb-2"><strong>Tanggal Bergabung:</strong>
                            {{ $member->join_date ? $member->join_date->format('d M Y') : '-' }}</p>
                        <p class="mb-2"><strong>Terakhir Diperbarui:</strong>
                            {{ $member->updated_at->format('d M Y H:i:s') }}</p>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.members.edit', $member->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mr-2">Edit
                            Anggota</a>
                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md">Hapus
                                Anggota</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
