@extends('layouts.admin.app')

@section('title', '| Presentasi Persembahan Mingguan Gereja')

@section('content')
    <div class="container mx-auto p-6 space-y-10">

        {{-- Navigasi Cepat --}}
        <div class="flex gap-4 mb-6">
            <a href="#asm" class="px-4 py-2 bg-indigo-100 rounded hover:bg-indigo-200">ASM</a>
            <a href="#adult" class="px-4 py-2 bg-yellow-100 rounded hover:bg-yellow-200">Dewasa</a>
            <a href="#pks" class="px-4 py-2 bg-purple-100 rounded hover:bg-purple-200">PKS</a>
            <a href="#lelang" class="px-4 py-2 bg-green-100 rounded hover:bg-green-200">Lelang</a>
            <a href="#lain" class="px-4 py-2 bg-blue-100 rounded hover:bg-blue-200">Lain-lain</a>
            <a href="#expense" class="px-4 py-2 bg-red-100 rounded hover:bg-red-200">Pengeluaran</a>

        </div>

        {{-- Persembahan ASM --}}
        <section id="asm" class="bg-indigo-50 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-4 text-indigo-800">✨ Persembahan Anak Sekolah Minggu</h2>
            <p class="mb-4 text-gray-700">Minggu Ini: {{ $thisWeekStart->format('d M Y') }} -
                {{ $thisWeekEnd->format('d M Y') }}</p>
            <ul class="space-y-2">
                @forelse ($asmThisWeek as $income)
                    <li class="bg-indigo-100 px-4 py-2 rounded flex justify-between">
                        <span>{{ $income->transaction_date->format('d M Y') }} - {{ $income->description ?? '-' }}</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-lg">
                            Rp {{ number_format($income->amount, 2) }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-400 text-center">Tidak ada data</li>
                @endforelse
            </ul>
        </section>

        {{-- Persembahan Orang Dewasa --}}
        <section id="adult" class="bg-yellow-50 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-4 text-yellow-800">👨‍👩‍👧 Persembahan Orang Dewasa</h2>
            <p class="mb-4 text-gray-700">Minggu Lalu: {{ $lastWeekStart->format('d M Y') }} -
                {{ $lastWeekEnd->format('d M Y') }}</p>
            <ul class="space-y-2">
                @forelse ($adultLastWeek as $income)
                    <li class="bg-yellow-100 px-4 py-2 rounded flex justify-between">
                        <span>{{ $income->transaction_date->format('d M Y') }} - {{ $income->description ?? '-' }}</span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold text-lg">
                            Rp {{ number_format($income->amount, 2) }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-400 text-center">Tidak ada data</li>
                @endforelse
            </ul>
        </section>

        {{-- Persembahan PKS --}}
        <section id="pks" class="bg-purple-50 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-4 text-purple-800">🏠 Persembahan PKS</h2>
            <p class="mb-4 text-gray-700">Minggu Lalu: {{ $lastWeekStart->format('d M Y') }} -
                {{ $lastWeekEnd->format('d M Y') }}</p>
            <table class="min-w-full table-auto border-collapse bg-white rounded-lg overflow-hidden">
                <thead class="bg-purple-200">
                    <tr class="text-left text-gray-700 uppercase text-sm">
                        <th class="px-4 py-2">Nama Keluarga</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Tanggal Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pksLastWeek as $schedule)
                        @foreach ($schedule->families as $family)
                            <tr class="hover:bg-purple-50 transition-colors">
                                <td class="px-4 py-2">{{ $family->family_name }}</td>
                                <td class="px-4 py-2 font-semibold text-purple-700">
                                    Rp {{ number_format($family->pivot->offering, 2) }}
                                </td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-400">Tidak ada data</td>
                        </tr>
                    @endforelse
                    <tr class="font-bold bg-purple-100">
                        <td>Total</td>
                        <td>Rp
                            {{ number_format($pksLastWeek->sum(fn($s) => $s->families->sum(fn($f) => $f->pivot->offering)), 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </section>

        {{-- Pembayaran Lelang --}}
        <section id="lelang" class="bg-green-50 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-4 text-green-800">💰 Pembayaran Lelang</h2>
            <p class="mb-4 text-gray-700">Minggu Lalu: {{ $lastWeekStart->format('d M Y') }} -
                {{ $lastWeekEnd->format('d M Y') }}</p>
            <table class="min-w-full table-auto border-collapse bg-white rounded-lg overflow-hidden">
                <thead class="bg-green-200">
                    <tr>
                        <th class="px-4 py-2">Tanggal Pembayaran</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Catatan</th>
                        <th class="px-4 py-2">Jemaat</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auctionPaymentsDetailLastWeek as $payment)
                        @php
                            $isInstallment = Str::contains(strtolower($payment->notes), 'panjar');

                            $label = $isInstallment ? 'Panjar Lelang' : 'Pelunasan';
                            $badgeClass = $isInstallment
                                ? 'bg-yellow-200 text-yellow-800'
                                : 'bg-green-200 text-green-800';
                        @endphp

                        <tr>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($payment->amount_paid, 2) }}</td>
                            {{-- Catatan (riwayat panjar/pelunasan) --}}
                            <td class="px-4 py-2">
                                {{ $payment->notes ?? '-' }}
                            </td>

                            <td class="px-4 py-2">{{ $payment->transaction->member->full_name ?? '-' }}</td>

                            <td class="px-4 py-2">
                                <span class="{{ $badgeClass }} px-2 py-1 rounded">
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-400">Tidak ada pembayaran</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
            <p class="mt-2 font-bold">Total Pembayaran Lelang: Rp {{ number_format($auctionPaymentsLastWeek, 2) }}</p>
        </section>
        {{-- Pemasukan Lain-lain --}}
        <section id="lain" class="bg-blue-50 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-4 text-blue-800">📌 Persembahan Lain-lain</h2>
            <p class="mb-4 text-gray-700">Minggu Lalu: {{ $lastWeekStart->format('d M Y') }} -
                {{ $lastWeekEnd->format('d M Y') }}</p>
            <ul class="space-y-2">
                @forelse ($otherIncomeLastWeek as $income)
                    <li class="bg-blue-100 px-4 py-2 rounded flex justify-between">
                        <span>{{ $income->transaction_date->format('d M Y') }} -
                            {{ $income->category->name ?? '-' }}</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-lg">
                            Rp {{ number_format($income->amount, 2) }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-400 text-center">Tidak ada data</li>
                @endforelse
            </ul>
            <p class="mt-2 font-bold">Total Persembahan Lain: Rp
                {{ number_format($otherIncomeLastWeek->sum('amount'), 2) }}
            </p>
        </section>

        {{-- Pengeluaran --}}
        <section id="expense" class="bg-red-50 shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold mb-4 text-red-800">💸 Pengeluaran</h2>
            <p class="mb-4 text-gray-700">Minggu Lalu: {{ $lastWeekStart->format('d M Y') }} -
                {{ $lastWeekEnd->format('d M Y') }}</p>
            <ul class="space-y-2">
                @forelse ($expensesLastWeek as $expense)
                    <li class="bg-red-100 px-4 py-2 rounded flex justify-between">
                        <span>{{ $expense->transaction_date->format('d M Y') }} -
                            {{ $expense->description ?? '-' }}</span>
                        <span class="bg-red-200 text-red-800 px-3 py-1 rounded-full font-bold text-lg">
                            Rp {{ number_format($expense->amount, 2) }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-400 text-center">Tidak ada pengeluaran</li>
                @endforelse
            </ul>
            <p class="mt-2 font-bold">Total Pengeluaran: Rp {{ number_format($expensesLastWeek->sum('amount'), 2) }}</p>
        </section>

    </div>
@endsection
