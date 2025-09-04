@extends('layouts.admin.app')
@section('title', '| Manajemen Lelang')

@section('content')
    <div class="container mx-auto max-w-7xl bg-white p-8 rounded-2xl shadow-xl">
        <h1 class="text-3xl sm:text-4xl font-bold text-center text-gray-800 mb-8">Manajemen Barang Lelang</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-blue-50 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-blue-800 mb-4">Tambah Barang Baru</h2>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="itemName" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" id="itemName" name="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                    </div>
                    <div>
                        <label for="itemDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="itemDescription" name="description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"></textarea>
                    </div>
                    <div>
                        <label for="itemCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <input type="text" id="itemCategory" name="category"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                    </div>
                    <div>
                        <label for="itemQuantity" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                        <input type="number" id="itemQuantity" name="total_quantity" required min="1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                    </div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Tambah Barang
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Barang Tersedia</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Barang</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->category ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->total_quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
