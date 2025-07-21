@extends('layouts.admin.app')

@section('title', '| Semua Notifikasi')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            {{ __('Semua Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold mb-6 dark:text-white">Daftar Semua Notifikasi Anda</h3>

                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-700 border border-green-400 dark:border-green-500 text-green-700 dark:text-white px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 dark:bg-red-700 border border-red-400 dark:border-red-500 text-red-700 dark:text-white px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($notifications->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">Tidak ada notifikasi yang tersedia.</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($notifications as $notification)
                                <div
                                    class="p-5 rounded-xl shadow-sm flex items-start justify-between transition-all duration-200
                                    {{ $notification->is_read ? 'bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700' : 'bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-400 dark:border-blue-500' }}">
                                    <div class="flex-1">
                                        <h5
                                            class="font-semibold mb-1 {{ $notification->is_read ? 'text-gray-700 dark:text-gray-200' : 'text-blue-800 dark:text-blue-300' }}">
                                            {{ $notification->title }}
                                        </h5>
                                        <p
                                            class="text-sm mb-2 {{ $notification->is_read ? 'text-gray-600 dark:text-gray-400' : 'text-blue-700 dark:text-blue-200' }}">
                                            {{ $notification->message }}
                                        </p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->format('d M Y H:i') }}
                                            ({{ $notification->created_at->diffForHumans() }})
                                        </span>
                                    </div>
                                    <div class="flex-shrink-0 ml-4 text-right">
                                        @if ($notification->link)
                                            <a href="{{ $notification->link }}"
                                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13 7h5v5m0 0L10 21l-5-5 11-11z" />
                                                </svg>
                                                <span>Lihat</span>
                                            </a>
                                        @endif
                                        @if (!$notification->is_read)
                                            <button type="button"
                                                class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white mt-2 mark-as-read-btn inline-flex items-center space-x-1"
                                                data-id="{{ $notification->id }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>Tandai Sudah Dibaca</span>
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500 mt-2 inline-block">✔️
                                                Sudah Dibaca</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif

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
                        const notificationCard = buttonElement.closest('.p-5');

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
                                    notificationCard.classList.remove('bg-blue-50', 'border-l-4',
                                        'border-blue-400');
                                    notificationCard.classList.add('bg-gray-50', 'border',
                                        'border-gray-200');
                                    notificationCard.querySelector('h5').classList.replace(
                                        'text-blue-800', 'text-gray-700');
                                    notificationCard.querySelector('p').classList.replace(
                                        'text-blue-700', 'text-gray-600');
                                    buttonElement.replaceWith(document.createTextNode(
                                        '✔️ Sudah Dibaca'));

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
