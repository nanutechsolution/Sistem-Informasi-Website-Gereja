@extends('layouts.admin.app')
@section('title', '| Laporan Pembayaran Mingguan')

@section('content')
    <div class="container mx-auto max-w-5xl bg-white p-8 rounded-2xl shadow-xl">
        <h1 class="text-3xl sm:text-4xl font-bold text-center text-gray-800 mb-2">Laporan Pembayaran Lelang</h1>
        <p class="text-center text-gray-600 mb-6">Data pembayaran lelang yang diterima.</p>

        <!-- Filter Tanggal -->
        <div class="bg-blue-50 p-6 rounded-xl shadow-inner mb-8">
            <form action="{{ route('admin.auction-transactions.report') }}" method="GET"
                class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-blue-800">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? '' }}"
                        class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-blue-800">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? '' }}"
                        class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                </div>
                <button type="submit"
                    class="mt-4 sm:mt-0 px-6 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Filter Laporan
                </button>
            </form>
        </div>

        @if (empty($reportData))
            <div class="text-center py-10 text-gray-500">
                <p>Tidak ada pembayaran yang tercatat pada rentang waktu ini.</p>
                <p class="mt-2">Terima kasih atas partisipasi Anda!</p>
            </div>
        @else
            @foreach ($reportData as $memberName => $payments)
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $memberName }}</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-700">{{ $payment['item_name'] }}</p>
                                    <p class="text-sm text-gray-500">
                                        Rp{{ number_format($payment['amount_paid'], 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-400">Tanggal:
                                        {{ \Carbon\Carbon::parse($payment['payment_date'])->translatedFormat('d F Y') }}</p>
                                </div>
                                @if ($payment['is_lunas'])
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Lunas
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Cicilan
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endif
    </div>
@endsection
