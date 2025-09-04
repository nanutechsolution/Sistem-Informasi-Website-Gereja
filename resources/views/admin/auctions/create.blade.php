@extends('layouts.admin.app')

@section('title', $auction->id ?? null ? 'Edit Barang' : 'Tambah Barang')

@section('content')
    <h2 class="text-xl font-bold mb-4">{{ $auction->id ?? null ? 'Edit Barang' : 'Tambah Barang' }}</h2>

    <form action="{{ $auction->id ?? null ? route('admin.auctions.update', $auction->id) : route('admin.auctions.store') }}"
        method="POST" class="space-y-4">
        @csrf
        @if ($auction->id ?? false)
            @method('PUT')
        @endif

        <div>
            <label for="item_name">Nama Barang</label>
            <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $auction->item_name ?? '') }}"
                class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label for="total_quantity">Total Barang</label>
            <input type="number" name="total_quantity" id="total_quantity"
                value="{{ old('total_quantity', $auction->total_quantity ?? 1) }}" class="w-full border p-2 rounded"
                required>
        </div>

        <div>
            <label for="base_price">Harga Dasar</label>
            <input type="number" name="base_price" id="base_price"
                value="{{ old('base_price', $auction->base_price ?? 0) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status" class="w-full border p-2 rounded">
                <option value="pending" {{ old('status', $auction->status ?? '') == 'pending' ? 'selected' : '' }}>Pending
                </option>
                <option value="lunas" {{ old('status', $auction->status ?? '') == 'lunas' ? 'selected' : '' }}>Lunas
                </option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
@endsection
