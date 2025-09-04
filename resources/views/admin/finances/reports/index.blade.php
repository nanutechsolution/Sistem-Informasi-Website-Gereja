@extends('layouts.admin.app')
@section('title', '| Laporan Keuangan')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Laporan Keuangan Gereja</h3>
                    {{-- Filter Tanggal --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-sm">
                        <form action="{{ route('admin.finances.reports') }}" method="GET"
                            class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    value="{{ $startDate->format('Y-m-d') }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    value="{{ $endDate->format('Y-m-d') }}">
                            </div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Filter
                            </button>
                            <a href="{{ route('admin.finances.reports') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-md">
                                Reset
                            </a>
                        </form>
                    </div>

                    {{-- Ringkasan Keuangan --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-100 p-6 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Total Pemasukan</h4>
                            <p class="text-3xl font-bold text-green-900">Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-red-100 p-6 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-red-800 mb-2">Total Pengeluaran</h4>
                            <p class="text-3xl font-bold text-red-900">Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold text-blue-800 mb-2">Saldo Akhir</h4>
                            <p class="text-3xl font-bold text-blue-900">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-indigo-100 p-6 rounded-lg shadow-md hover:shadow-xl">
                            <h4 class="text-lg font-semibold text-indigo-800 mb-2">Total Persembahan PKS</h4>
                            <p class="text-3xl font-bold text-indigo-900">Rp
                                {{ number_format($currentMonthOffering, 0, ',', '.') }}</p>
                        </div>
                    </div>


                    {{-- Grafik Keuangan --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h4 class="text-xl font-bold mb-4 text-green-700">Pemasukan per Kategori</h4>
                            <div class="relative h-80">
                                <canvas id="incomePieChart"></canvas>
                            </div>
                            @if (empty($incomeChartData))
                                <p class="text-center text-gray-600 mt-4">Tidak ada data pemasukan untuk periode ini.</p>
                            @endif
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h4 class="text-xl font-bold mb-4 text-red-700">Pengeluaran per Kategori</h4>
                            <div class="relative h-80">
                                <canvas id="expensePieChart"></canvas>
                            </div>
                            @if (empty($expenseChartData))
                                <p class="text-center text-gray-600 mt-4">Tidak ada data pengeluaran untuk periode ini.</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                        <h4 class="text-xl font-bold mb-4 text-gray-800">Tren Keuangan Bulanan</h4>
                        <div class="relative h-96">
                            <canvas id="monthlyTrendChart"></canvas>
                        </div>
                        @if (empty($monthlyIncomeData) && empty($monthlyExpenseData))
                            <p class="text-center text-gray-600 mt-4">Tidak ada data bulanan untuk periode ini.</p>
                        @endif
                    </div>


                    {{-- Detail Transaksi (Tabel) --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Tabel Pemasukan --}}
                        <div>
                            <h4 class="text-xl font-bold mb-4 text-green-700">Detail Pemasukan</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Deskripsi
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kategori
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumlah
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($incomes as $income)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $income->transaction_date->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ Str::limit($income->description, 40) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $income->category->name ?? 'N/A' }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">
                                                    Rp {{ number_format($income->amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    Tidak ada data pemasukan dalam rentang tanggal ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Tabel Pengeluaran --}}
                        <div>
                            <h4 class="text-xl font-bold mb-4 text-red-700">Detail Pengeluaran</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Deskripsi
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kategori
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumlah
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($expenses as $expense)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $expense->transaction_date->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ Str::limit($expense->description, 40) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $expense->category->name ?? 'N/A' }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">
                                                    Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    Tidak ada data pengeluaran dalam rentang tanggal ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        // Hapus type="module" karena Chart sudah global
        document.addEventListener('DOMContentLoaded', function() {
            // Debugging console logs
            console.log('DOM Content Loaded for reports page.');
            // Pastikan Chart.js sudah dimuat secara global
            if (typeof window.Chart === 'undefined') {
                console.error('Chart.js is NOT available globally. Check app.js and Vite compilation.');
                return; // Hentikan eksekusi jika Chart.js tidak ada
            }
            const Chart = window.Chart; // Ambil Chart dari global window

            // Ambil data dari Blade ke JavaScript
            const incomeChartLabels = @json($incomeChartLabels);
            const incomeChartData = @json($incomeChartData);
            const incomeChartColors = @json($incomeChartColors);

            const expenseChartLabels = @json($expenseChartLabels);
            const expenseChartData = @json($expenseChartData);
            const expenseChartColors = @json($expenseChartColors);

            const monthlyChartLabels = @json($monthlyChartLabels);
            const monthlyIncomeData = @json($monthlyIncomeData);
            const monthlyExpenseData = @json($monthlyExpenseData);

            // Fungsi untuk membuat Pie Chart
            function createPieChart(ctxId, labels, data, colors) {
                const ctxElement = document.getElementById(ctxId);
                if (!ctxElement) {
                    console.error(`Canvas element with ID '${ctxId}' not found.`);
                    return;
                }
                const ctx = ctxElement.getContext('2d');

                if (data.length > 0 && data.some(val => val > 0)) {
                    console.log(`Attempting to create pie chart for ${ctxId}`);
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: colors,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed !== null) {
                                                label += 'Rp ' + context.parsed.toLocaleString('id-ID');
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    console.log(`Chart ${ctxId} created successfully.`);
                } else {
                    console.log(`No valid data for ${ctxId}, hiding canvas.`);
                    ctxElement.style.display = 'none';
                    const parent = ctxElement.parentElement;
                    if (parent) {
                        const noDataMsg = document.createElement('p');
                        noDataMsg.className = 'text-center text-gray-600 mt-4';
                        noDataMsg.textContent = 'Tidak ada data untuk grafik ini.';
                        parent.appendChild(noDataMsg);
                    }
                }
            }

            // Fungsi untuk membuat Line/Bar Chart
            function createLineBarChart(ctxId, labels, incomeData, expenseData) {
                const ctxElement = document.getElementById(ctxId);
                if (!ctxElement) {
                    console.error(`Canvas element with ID '${ctxId}' not found.`);
                    return;
                }
                const ctx = ctxElement.getContext('2d');

                if (labels.length > 0 && (incomeData.some(val => val > 0) || expenseData.some(val => val > 0))) {
                    console.log(`Attempting to create monthly trend chart for ${ctxId}`);
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Pemasukan',
                                    data: incomeData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                    tension: 0.3
                                },
                                {
                                    label: 'Pengeluaran',
                                    data: expenseData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                    tension: 0.3
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value, index, ticks) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += 'Rp ' + context.parsed.y.toLocaleString(
                                                    'id-ID');
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    console.log(`Chart ${ctxId} created successfully.`);
                } else {
                    console.log(`No valid data for ${ctxId}, hiding canvas.`);
                    ctxElement.style.display = 'none';
                    const parent = ctxElement.parentElement;
                    if (parent) {
                        const noDataMsg = document.createElement('p');
                        noDataMsg.className = 'text-center text-gray-600 mt-4';
                        noDataMsg.textContent = 'Tidak ada data bulanan untuk periode ini.';
                        parent.appendChild(noDataMsg);
                    }
                }
            }

            // Panggil fungsi-fungsi untuk merender grafik
            createPieChart('incomePieChart', incomeChartLabels, incomeChartData, incomeChartColors);
            createPieChart('expensePieChart', expenseChartLabels, expenseChartData, expenseChartColors);
            createLineBarChart('monthlyTrendChart', monthlyChartLabels, monthlyIncomeData, monthlyExpenseData);

        }); // End DOMContentLoaded
    </script>
@endpush
