@extends('layouts.admin.app')

@section('title', 'Tambah Bid')

@section('content')
    <h2 class="text-xl font-bold mb-4">Bid untuk: {{ $auction->item_name }}</h2>

    <form action="{{ route('admin.auctions.bids.store', $auction->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>Member</label>
            <select name="member_id" class="border p-2 rounded w-full">
                @foreach (\App\Models\Member::all() as $member)
                    <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Qty Ambil (Sisa: {{ $auction->remainingQuantity() }})</label>
            <input type="number" name="quantity_taken" class="border p-2 rounded w-full"
                max="{{ $auction->remainingQuantity() }}" required>
        </div>
        <div class="mb-4">
            <label>Jumlah Bayar</label>
            <input type="number" name="amount" class="border p-2 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label>Status</label>
            <select name="status" class="border p-2 rounded w-full">
                <option value="pending">Pending</option>
                <option value="cicilan">Cicilan</option>
                <option value="paid">Lunas</option>
            </select>
        </div>
        <div class="mb-4">
            <label>Tanggal Bayar</label>
            <input type="date" name="payment_date" class="border p-2 rounded w-full">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Bid</button>
    </form>
@endsection
