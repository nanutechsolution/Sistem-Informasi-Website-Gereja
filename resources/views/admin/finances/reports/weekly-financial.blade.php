@extends('layouts.admin.app')

@section('title', '| Presentasi Persembahan Mingguan Gereja')

@section('content')
    <div class="container mx-auto p-6" x-data="{ slide: 0 }">

        {{-- Slide ASM --}}
        <template x-if="slide === 0">
            <div x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90" class="bg-indigo-50 shadow-lg rounded-lg p-8">
                <h2 class="text-3xl font-bold mb-4 text-indigo-800">✨ Persembahan Anak Sekolah Minggu</h2>
                <p class="mb-4 text-gray-700">Minggu Ini: {{ $thisWeekStart->format('d M Y') }} -
                    {{ $thisWeekEnd->format('d M Y') }}</p>
                <ul class="space-y-2">
                    @forelse ($asmThisWeek as $income)
                        <li class="bg-indigo-100 px-4 py-2 rounded flex justify-between">
                            <span>{{ $income->transaction_date->format('d M Y') }} -
                                {{ $income->description ?? '-' }}</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-lg">
                                Rp {{ number_format($income->amount, 2) }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-400 text-center">Tidak ada data</li>
                    @endforelse
                </ul>
            </div>
        </template>

        {{-- Slide Orang Dewasa --}}
        <template x-if="slide === 1">
            <div x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90" class="bg-yellow-50 shadow-lg rounded-lg p-8">
                <h2 class="text-3xl font-bold mb-4 text-yellow-800">👨‍👩‍👧 Persembahan Orang Dewasa</h2>
                <p class="mb-4 text-gray-700">Minggu Lalu: {{ $lastWeekStart->format('d M Y') }} -
                    {{ $lastWeekEnd->format('d M Y') }}</p>
                <ul class="space-y-2">
                    @forelse ($adultLastWeek as $income)
                        <li class="bg-yellow-100 px-4 py-2 rounded flex justify-between">
                            <span>{{ $income->transaction_date->format('d M Y') }} -
                                {{ $income->description ?? '-' }}</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold text-lg">
                                Rp {{ number_format($income->amount, 2) }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-400 text-center">Tidak ada data</li>
                    @endforelse
                </ul>
            </div>
        </template>

        {{-- Slide PKS --}}
        <template x-if="slide === 2">
            <div x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90" class="bg-purple-50 shadow-lg rounded-lg p-8">
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
                                    <td class="px-4 py-2 font-semibold text-purple-700">Rp
                                        {{ number_format($family->pivot->offering, 2) }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                                    </td>
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
            </div>
        </template>

        {{-- Slide Lelang --}}
        <template x-if="slide === 3">
            <div x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90" class="bg-green-50 shadow-lg rounded-lg p-8">
                <h2 class="text-3xl font-bold mb-4 text-green-800">💰 Pembayaran Lelang (Minggu Lalu)</h2>
                <p class="mb-4 text-gray-700">{{ $lastWeekStart->format('d M Y') }} - {{ $lastWeekEnd->format('d M Y') }}
                </p>
                <table class="min-w-full table-auto border-collapse bg-white rounded-lg overflow-hidden">
                    <thead class="bg-green-200">
                        <tr>
                            <th class="px-4 py-2">Tanggal Pembayaran</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Catatan</th>
                            <th class="px-4 py-2">Nama Member</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auctionPaymentsDetailLastWeek as $payment)
                            <tr>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($payment->amount_paid, 2) }}</td>
                                <td class="px-4 py-2">{{ $payment->notes ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $payment->transaction->member->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="{{ $payment->transaction->payment_status == 'paid' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }} px-2 py-1 rounded">
                                        {{ ucfirst($payment->transaction->payment_status) }}
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
            </div>
        </template>

        {{-- Navigasi --}}
        <div class="mt-6 flex justify-between">
            <button class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                @click="slide = slide > 0 ? slide - 1 : 0">Kembali</button>
            <button @click="slide = slide < 3 ? slide + 1 : 3"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Selanjutnya</button>
        </div>
    </div>
@endsection
