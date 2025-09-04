@extends('layouts.admin.app')

@section('title', 'Tambah Bid')

@section('content')
    <h2 class="text-xl font-bold mb-4">Tambah Bid untuk: {{ $auction->item_name }}</h2>

    <form action="{{ route('admin.bids.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="auction_id" value="{{ $auction->id }}">

        <div>
            <label for="member_id">Member</label>
            <select name="member_id" id="member_id" class="w-full border p-2 rounded" required>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="quantity_taken">Qty Ambil (Sisa: {{ $auction->remainingQuantity() }})</label>
            <input type="number" name="quantity_taken" id="quantity_taken" min="1"
                max="{{ $auction->remainingQuantity() }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label for="amount">Jumlah Bayar</label>
            <input type="number" name="amount" id="amount" class="w-full border p-2 rounded" value="0" required>
        </div>

        <div>
            <label for="status">Status Pembayaran</label>
            <select name="status" id="status" class="w-full border p-2 rounded" required>
                <option value="pending">Pending</option>
                <option value="cicilan">Cicilan</option>
                <option value="lunas">Lunas</option>
            </select>
        </div>

        <div>
            <label for="payment_date">Tanggal Bayar (Opsional)</label>
            <input type="date" name="payment_date" id="payment_date" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
@endsection
