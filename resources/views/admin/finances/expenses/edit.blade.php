@extends('layouts.admin.app')

@section('title', '| Edit Pengeluaran')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengeluaran') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="expense_category_id" class="block text-sm font-medium text-gray-700">Kategori
                                Pengeluaran</label>
                            <select name="expense_category_id" id="expense_category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('expense_category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                            <input type="number" name="amount" id="amount" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('amount', $expense->amount) }}" required>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700">Tanggal
                                Transaksi</label>
                            <input type="date" name="transaction_date" id="transaction_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('transaction_date', $expense->transaction_date->format('Y-m-d')) }}" required>
                            @error('transaction_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="recipient" class="block text-sm font-medium text-gray-700">Penerima
                                (Opsional)</label>
                            <input type="text" name="recipient" id="recipient"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                value="{{ old('recipient', $expense->recipient) }}">
                            @error('recipient')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi/Keterangan
                                (Opsional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description', $expense->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="proof_of_transaction" class="block text-sm font-medium text-gray-700">Bukti
                                Transaksi (Opsional, PDF/Gambar Max 5MB)</label>
                            @if ($expense->proof_of_transaction)
                                <div class="mt-2 mb-2">
                                    <p class="text-sm text-gray-600">Bukti saat ini: <a
                                            href="{{ asset('storage/' . $expense->proof_of_transaction) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat Bukti</a></p>
                                </div>
                            @endif
                            <input type="file" name="proof_of_transaction" id="proof_of_transaction"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah bukti.</p>
                            @error('proof_of_transaction')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.expenses.index') }}"
                                class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Perbarui Pengeluaran
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
