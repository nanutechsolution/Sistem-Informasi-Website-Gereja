@extends('layouts.admin.app')

@section('title', '| Dashboard Admin')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                {{-- Stat Cards --}}
                <div class="mt-6 grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                    {{-- Total Jemaat --}}
                    <x-dashboard.card title="Total Jemaat" color="red" :value="$totalMembers" />

                    {{-- Jemaat Aktif --}}
                    <x-dashboard.card title="Total Jemaat Aktif" color="yellow" :value="$totalActiveMembers" />

                    {{-- Jemaat Pindah --}}
                    <x-dashboard.card title="Total Jemaat Pindah" color="green" :value="$totalPindahMembers" />

                    {{-- Jemaat Meninggal --}}
                    <x-dashboard.card title="Total Jemaat Meninggal" color="blue" :value="$totalDeadMembers" />

                    {{-- Pengumuman Aktif --}}
                    <x-dashboard.card title="Pengumuman Aktif" color="indigo" :value="$totalPublishedPosts" />

                    {{-- Acara Mendatang --}}
                    <x-dashboard.card title="Acara Mendatang" color="purple" :value="$totalUpcomingEvents" />

                </div>

                {{-- Notifications --}}
                <div class="mt-8">
                    <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-4">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-white">Notifikasi Terbaru</h4>
                        @if ($notifications->count() > 0)
                            <a href="{{ route('admin.notifications.index') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm mt-2 sm:mt-0">
                                Lihat Semua Notifikasi
                            </a>
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
                                        <h5 class="font-bold text-blue-800 dark:text-white">
                                            {{ $notification->title }}
                                        </h5>
                                        <p class="text-sm text-blue-700 dark:text-gray-300">
                                            {{ $notification->message }}
                                        </p>
                                        <span class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="mt-2 sm:mt-0 sm:ml-4 flex gap-2">
                                        @if ($notification->link)
                                            <a href="{{ $notification->link }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm">Lihat</a>
                                        @endif
                                        <button type="button"
                                            class="text-gray-500 hover:text-gray-700 text-sm mark-as-read-btn"
                                            data-id="{{ $notification->id }}">
                                            Tandai Sudah Dibaca
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Quick Access --}}
                <div class="mt-10">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Akses Cepat</h3>
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                        <x-dashboard.quick-link route="admin.posts.create" color="blue" title="Buat Postingan Baru"
                            icon="plus" />
                        <x-dashboard.quick-link route="admin.members.index" color="green" title="Kelola Jemaat"
                            icon="users" />
                        <x-dashboard.quick-link route="admin.finances.reports" color="purple" title="Laporan Keuangan"
                            icon="report" />
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

                                    // Update badge di sidebar
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
