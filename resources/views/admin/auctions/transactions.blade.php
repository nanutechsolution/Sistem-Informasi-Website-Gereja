@extends('layouts.admin.app')

@section('title', '| Manajemen Transaksi Lelang')

@section('content')

    <div class="min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-10">
        <div class="container mx-auto max-w-7xl">
            {{-- Header --}}
            <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-2">Pencatatan Transaksi & Pembayaran</h1>
            <p class="text-center text-sm sm:text-base text-gray-600 mb-6 sm:mb-10">Kelola riwayat lelang, status pembayaran,
                dan cicilan.</p>
            {{-- Flash Message --}}
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-400 font-medium animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Form Catat Transaksi Baru (Optimasi Mobile) --}}
            <button onclick="toggleFormTransaksi()"
                class="py-2 px-3 my-2 rounded-full border border-indigo-400 text-indigo-600 font-medium text-xs hover:bg-indigo-50 transition-colors">
                Transaksi Baru
            </button>
            <div id="formTransaksiBaru"
                class="hidden bg-white shadow-lg rounded-2xl p-6 mb-8 sm:mb-10 border border-gray-200">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6 border-b pb-4">Catat Transaksi Baru</h2>
                <form action="{{ route('admin.auction-transactions.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="transactionItem" class="block text-sm font-medium text-gray-700">Barang
                                Lelang</label>
                            <select id="transactionItem" name="auction_item_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm">
                                <option value="" data-stock="0">Pilih Barang...</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}" data-stock="{{ $item->total_quantity }}">
                                        {{ $item->name }} (Stok: {{ $item->total_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="transactionMember" class="block text-sm font-medium text-gray-700">Nama
                                Jemaat</label>
                            <select id="transactionMember" name="member_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm">
                                <option value="">Pilih Jemaat...</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="transactionQuantity" class="block text-sm font-medium text-gray-700">Jumlah
                                Dibeli</label>
                            <input type="number" id="transactionQuantity" name="quantity_bought" required min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm">
                            <p id="stockInfo" class="mt-1 text-xs text-gray-500 italic"></p>
                        </div>

                        <div>
                            <label for="transactionPrice" class="block text-sm font-medium text-gray-700">Harga
                                Akhir</label>
                            <input type="number" id="transactionPrice" name="final_price" required min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm">
                        </div>

                        <div>
                            <label for="transactionStatus" class="block text-sm font-medium text-gray-700">Status Pembayaran
                                Awal</label>
                            <select id="transactionStatus" name="payment_status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm">
                                <option value="pending">Belum Bayar</option>
                                <option value="installment">Cicilan</option>
                                <option value="paid">Lunas</option>
                            </select>
                        </div>
                        <div id="initialPaymentContainer" class="hidden">
                            <label for="initialPayment" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran
                                Awal</label>
                            <input type="number" id="initialPayment" name="initial_payment" min="0" value="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm">
                        </div>

                        <div class="col-span-1 md:col-span-2 lg:col-span-3">
                            <label for="transactionNotes" class="block text-sm font-medium text-gray-700">Catatan</label>
                            <textarea id="transactionNotes" name="notes" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-2 text-sm"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full sm:w-1/2 md:w-1/3 mt-4 flex justify-center py-2 px-6 rounded-full bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-colors shadow-md">
                        Catat Transaksi
                    </button>
                </form>
            </div>
            {{-- Filter Section (Optimasi Mobile) --}}
            <div class="bg-white shadow-lg rounded-2xl p-6 mb-8 sm:mb-10 border border-gray-200">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Filter Riwayat Transaksi</h2>
                <form action="{{ route('admin.auction-transactions.index') }}" method="GET"
                    class="space-y-4 md:space-y-0 md:flex md:gap-4 md:items-end">

                    <div class="flex-1">
                        <label for="startDate" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" id="startDate" name="start_date" value="{{ request('start_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm">
                    </div>

                    <div class="flex-1">
                        <label for="endDate" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" id="endDate" name="end_date" value="{{ request('end_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm">
                    </div>

                    <div class="flex-1">
                        <label for="filterStatus" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                        <select id="filterStatus" name="payment_status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Belum
                                Bayar</option>
                            <option value="installment"
                                {{ request('payment_status') == 'installment' ? 'selected' : '' }}>
                                Cicilan</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas
                            </option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="filterMember" class="block text-sm font-medium text-gray-700">Nama Jemaat</label>
                        <select id="filterMember" name="member_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm">
                            <option value="">Semua Jemaat</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ request('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2 w-full md:w-auto mt-4 md:mt-0">
                        <button type="submit"
                            class="w-full py-2 px-6 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors shadow-sm text-center">
                            Filter
                        </button>
                        <a href="{{ route('admin.auction-transactions.index') }}"
                            class="w-full py-2 px-6 rounded-full bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition-colors shadow-sm text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            {{-- Riwayat Transaksi --}}
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6 border-b pb-4">Riwayat Transaksi &
                    Pembayaran</h2>

                {{-- Tampilan Kartu untuk Mobile --}}
                <div class="md:hidden space-y-4">
                    @forelse ($transactions as $transaction)
                        @php
                            $totalPaid = $transaction->payments->sum('amount_paid');
                            $remaining = $transaction->final_price - $totalPaid;
                        @endphp
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm border-l-4 border-gray-400">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-lg font-bold text-gray-900">
                                        {{ $transaction->member->full_name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $transaction->item->name ?? 'N/A' }}
                                        ({{ $transaction->quantity_bought }} unit)
                                    </p>
                                </div>
                                <div>
                                    <span
                                        class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
                                @if ($transaction->payment_status === 'paid') bg-green-100
                                @elseif($transaction->payment_status === 'installment') text-yellow-800
                                @else @endif">
                                        {{ ucfirst($transaction->payment_status == 'paid' ? 'Lunas' : ($transaction->payment_status == 'installment' ? 'Cicilan' : 'Belum Lunas')) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 flex justify-between items-center text-sm">
                                <p class="text-gray-700">Total: <span
                                        class="font-semibold">Rp{{ number_format($transaction->final_price, 0, ',', '.') }}</span>
                                </p>
                                @if ($remaining > 0)
                                    <p class="text-red-500 text-xs font-semibold">Sisa:
                                        Rp{{ number_format($remaining, 0, ',', '.') }}</p>
                                @endif
                            </div>

                            <div class="mt-4 flex gap-2">
                                <button data-transaction-id="{{ $transaction->id }}"
                                    class="btn-show-payments flex-1 py-2 rounded-full border border-blue-400 text-blue-600 font-medium text-xs hover:bg-blue-50 transition-colors">
                                    Lihat Riwayat Bayar
                                </button>
                                @if ($transaction->payment_status !== 'paid')
                                    <button onclick="togglePaymentForm({{ $transaction->id }})"
                                        class="flex-1 py-2 rounded-full border border-indigo-400 text-indigo-600 font-medium text-xs hover:bg-indigo-50 transition-colors">
                                        Catat Pembayaran
                                    </button>
                                @endif
                            </div>

                            {{-- Form Cicilan di Mobile --}}
                            <div id="paymentForm-{{ $transaction->id }}"
                                class="hidden bg-white p-4 mt-4 rounded-xl border border-dashed border-gray-300">
                                <form action="{{ route('admin.auction-transactions.recordPayment', $transaction) }}"
                                    method="POST" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700">Jumlah Bayar</label>
                                        <input type="number" name="amount_paid" required min="1"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700">Tanggal</label>
                                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    </div>
                                    <button type="submit"
                                        class="w-full py-2 px-4 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors shadow-sm text-sm">
                                        Simpan Pembayaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">Belum ada riwayat transaksi yang tercatat.</div>
                    @endforelse
                </div>

                {{-- Tampilan Tabel untuk Desktop --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jemaat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Harga Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                @php
                                    $totalPaid = $transaction->payments->sum('amount_paid');
                                    $remaining = $transaction->final_price - $totalPaid;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $transaction->member->full_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->item->name ?? 'N/A' }} ({{ $transaction->quantity_bought }} unit)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Rp{{ number_format($transaction->final_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="px-2 inline-flex text-xs font-semibold rounded-full
                                        @if ($transaction->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($transaction->payment_status === 'installment') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                        @if ($remaining > 0)
                                            <p class="text-xs text-red-500 mt-1">Sisa:
                                                Rp{{ number_format($remaining, 0, ',', '.') }}</p>
                                        @endif
                                        <button data-transaction-id="{{ $transaction->id }}"
                                            class="btn-show-payments mt-1 text-blue-500 hover:text-blue-700 text-xs transition-colors">Lihat
                                            Riwayat Bayar</button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if ($transaction->payment_status !== 'paid')
                                            <button onclick="togglePaymentForm({{ $transaction->id }})"
                                                class="text-indigo-600 hover:text-indigo-900 text-xs transition-colors py-1 px-2 rounded-lg border border-indigo-200 hover:bg-indigo-50">Catat
                                                Pembayaran</button>
                                        @endif
                                    </td>
                                </tr>

                                {{-- Form Cicilan di Desktop --}}
                                <tr id="paymentFormDesktop-{{ $transaction->id }}" class="hidden bg-gray-50">
                                    <td colspan="5" class="p-4">
                                        <form
                                            action="{{ route('admin.auction-transactions.recordPayment', $transaction) }}"
                                            method="POST"
                                            class="flex flex-col md:flex-row md:items-end md:space-x-3 space-y-2 md:space-y-0 p-4 rounded-xl border border-dashed border-gray-300 bg-white shadow-inner">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Jumlah Bayar</label>
                                                <input type="number" name="amount_paid" required min="1"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Tanggal</label>
                                                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}"
                                                    required
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                                            </div>
                                            <button type="submit"
                                                class="py-2 px-4 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors shadow-sm text-sm">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada
                                        riwayat transaksi yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Riwayat Pembayaran --}}
        <div id="paymentModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 hidden transition-opacity duration-300">
            <div
                class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl transform transition-transform duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200 mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Pembayaran</h3>
                        <button onclick="closeModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors text-2xl leading-none">&times;</button>
                    </div>
                    <div id="paymentHistoryContent" class="space-y-3">
                        <p class="text-center text-gray-500">Memuat...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-show-payments');
            buttons.forEach(button => {
                button.addEventListener('click', async function() {
                    const transactionId = this.dataset.transactionId;
                    const modal = document.getElementById('paymentModal');
                    const content = document.getElementById('paymentHistoryContent');

                    content.innerHTML = '<p class="text-center text-gray-500">Memuat...</p>';
                    modal.classList.remove('hidden');

                    try {
                        const response = await fetch(
                            `auction-transactions/${transactionId}/history`);
                        if (!response.ok) throw new Error('Gagal memuat riwayat pembayaran.');
                        const payments = await response.json();

                        if (payments.length > 0) {
                            content.innerHTML = payments.map(payment => `
                        <div class="border-b last:border-b-0 py-2">
                            <p class="text-sm font-medium text-gray-900">Rp${new Intl.NumberFormat('id-ID').format(payment.amount_paid)}</p>
                            <p class="text-xs text-gray-500">Tanggal: ${new Date(payment.payment_date).toLocaleDateString('id-ID')}</p>
                        </div>
                    `).join('');
                        } else {
                            content.innerHTML =
                                '<p class="text-center text-gray-500">Belum ada pembayaran dicatat.</p>';
                        }

                    } catch (error) {
                        content.innerHTML =
                            `<p class="text-center text-red-500">Error: ${error.message}</p>`;
                        console.error('Error:', error);
                    }
                });
            });

            const itemSelect = document.getElementById('transactionItem');
            const quantityInput = document.getElementById('transactionQuantity');
            const stockInfo = document.getElementById('stockInfo');

            itemSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stock = selectedOption.dataset.stock;

                if (stock !== undefined) {
                    quantityInput.max = stock;
                    stockInfo.textContent = `Stok tersedia: ${stock} unit`;
                    quantityInput.value = '';
                }
            });

            const statusSelect = document.getElementById('transactionStatus');
            const initialPaymentContainer = document.getElementById('initialPaymentContainer');
            const initialPaymentInput = document.getElementById('initialPayment');

            statusSelect.addEventListener('change', function() {
                if (this.value === 'installment' || this.value === 'paid') {
                    initialPaymentContainer.classList.remove('hidden');
                    initialPaymentInput.setAttribute('required', 'required');
                } else {
                    initialPaymentContainer.classList.add('hidden');
                    initialPaymentInput.removeAttribute('required');
                }
            });
        });

        function togglePaymentForm(transactionId) {
            // Toggle form for mobile
            const formMobile = document.getElementById(`paymentForm-${transactionId}`);
            if (formMobile) {
                formMobile.classList.toggle('hidden');
            }

            const formDesktop = document.getElementById(`paymentFormDesktop-${transactionId}`);
            if (formDesktop) {
                formDesktop.classList.toggle('hidden');
            }
        }

        function toggleFormTransaksi() {
            // Toggle form for mobile
            const isShow = document.getElementById('formTransaksiBaru');
            if (isShow) {
                isShow.classList.toggle('hidden');
            }

        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>


@endsection
