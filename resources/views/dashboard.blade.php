@extends('layouts.admin.app')

@section('title', '| Dashboard Admin')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                <p class="text-gray-900 dark:text-gray-200 text-lg font-medium">
                    {{ __('Anda berhasil login sebagai Admin!') }}
                </p>

                <div class="mt-6 grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                    <div
                        class="bg-blue-100 p-6 rounded-lg shadow-lg border-l-4 border-blue-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Total Jemaat</h3>
                            <p class="text-3xl font-bold text-blue-900">{{ number_format($totalMembers, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-blue-100 p-6 rounded-lg shadow-lg border-l-4 border-blue-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Total Jemaat Aktif</h3>
                            <p class="text-3xl font-bold text-blue-900">
                                {{ number_format($totalActiveMembers, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-blue-100 p-6 rounded-lg shadow-lg border-l-4 border-blue-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Total Jemaat Pindah</h3>
                            <p class="text-3xl font-bold text-blue-900">
                                {{ number_format($totalPindahMembers, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-blue-100 p-6 rounded-lg shadow-lg border-l-4 border-blue-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Total Jemaat Meninggal</h3>
                            <p class="text-3xl font-bold text-blue-900">
                                {{ number_format($totalDeadMembers, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-green-100 p-6 rounded-lg shadow-lg border-l-4 border-green-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-green-800 mb-1">Pengumuman Aktif</h3>
                            <p class="text-3xl font-bold text-green-900">
                                {{ number_format($totalPublishedPosts, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-purple-100 p-6 rounded-lg shadow-lg border-l-4 border-purple-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-purple-800 mb-1">Acara Mendatang</h3>
                            <p class="text-3xl font-bold text-purple-900">
                                {{ number_format($totalUpcomingEvents, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-yellow-100 p-6 rounded-lg shadow-lg border-l-4 border-yellow-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-1">Pemasukan</h3>
                            <p class="text-3xl font-bold text-yellow-900">Rp
                                {{ number_format($currentMonthIncome, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-yellow-100 p-6 rounded-lg shadow-lg border-l-4 border-yellow-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-1">Pengeluaran</h3>
                            <p class="text-3xl font-bold text-yellow-900">Rp
                                {{ number_format($currentMonthExpense, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div
                        class="bg-yellow-100 p-6 rounded-lg shadow-lg border-l-4 border-yellow-500 hover:shadow-xl transition-all">
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-1">Saldo Bulan Ini</h3>
                            <p class="text-3xl font-bold text-yellow-900">Rp
                                {{ number_format($currentMonthBalance, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-4">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-white">Notifikasi Terbaru</h4>
                        @if ($notifications->count() > 0)
                            <a href="{{ route('admin.notifications.index') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm mt-2 sm:mt-0">Lihat Semua Notifikasi</a>
                        @endif
                    </div>

                    @if ($notifications->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">Tidak ada notifikasi baru.</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($notifications as $notification)
                                <div
                                    class="bg-blue-50 dark:bg-gray-700 border-l-4 border-blue-400 p-4 rounded-lg flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div>
                                        <h5 class="font-bold text-blue-800 dark:text-white">{{ $notification->title }}</h5>
                                        <p class="text-sm text-blue-700 dark:text-gray-300">{{ $notification->message }}
                                        </p>
                                        <span
                                            class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-2 sm:mt-0 sm:ml-4 flex gap-2">
                                        @if ($notification->link)
                                            <a href="{{ $notification->link }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                        @endif
                                        <button type="button"
                                            class="text-gray-500 hover:text-gray-700 text-sm mark-as-read-btn"
                                            data-id="{{ $notification->id }}">Tandai Sudah Dibaca</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-10">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Akses Cepat</h3>
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                        <a href="{{ route('admin.posts.create') }}"
                            class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5 flex flex-col items-center text-center hover:ring-2 hover:ring-blue-400 transition-all">
                            <svg class="w-10 h-10 text-blue-600 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="font-medium text-lg">Buat Postingan Baru</span>
                        </a>
                        <a href="{{ route('admin.members.index') }}"
                            class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5 flex flex-col items-center text-center hover:ring-2 hover:ring-green-400 transition-all">
                            <svg class="w-10 h-10 text-green-600 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h-1.5a4 4 0 00-7 0H7a2 2 0 01-2-2v-2a4 4 0 014-4h6a4 4 0 014 4v2a2 2 0 01-2 2zM12 14a4 4 0 100-8 4 4 0 000 8z">
                                </path>
                            </svg>
                            <span class="font-medium text-lg">Kelola Jemaat</span>
                        </a>
                        <a href="{{ route('admin.finances.reports') }}"
                            class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5 flex flex-col items-center text-center hover:ring-2 hover:ring-purple-400 transition-all">
                            <svg class="w-10 h-10 text-purple-600 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span class="font-medium text-lg">Laporan Keuangan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.mark-as-read-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const notificationId = this.dataset.id;
                        const buttonElement = this;

                        fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    buttonElement.closest('.bg-blue-50').remove();
                                    const unreadCountSpan = document.querySelector(
                                        '.sidebar .bg-red-500');
                                    if (unreadCountSpan) {
                                        let currentCount = parseInt(unreadCountSpan.textContent);
                                        if (currentCount > 1) {
                                            unreadCountSpan.textContent = currentCount - 1;
                                        } else {
                                            unreadCountSpan.remove();
                                        }
                                    }
                                } else {
                                    alert('Gagal menandai notifikasi sebagai sudah dibaca.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat menandai notifikasi.');
                            });
                    });
                });
            });
        </script>
    @endpush
@endsection
