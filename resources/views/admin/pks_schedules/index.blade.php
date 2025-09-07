@extends('layouts.admin.app')

@section('title', 'Manajemen PKS Schedule')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jadwal PKS') }}
        </h2>
    </x-slot>

    <div class="py-4"x-data="offeringModal()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Jadwal PKS</h3>
                        <a href="{{ route('admin.families.index') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                            Tambah Jadwal Baru
                        </a>
                    </div>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Tabel PKS --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keluarga</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hari</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jam</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pemimpin</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Firman Tuhan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Anggota Terlibat</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $schedule->families->pluck('family_name')->implode(', ') ?: 'N/A' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $schedule->day_of_week ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ optional($schedule->leader)->name ?? 'Belum Ada Pemimpin PKS' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $schedule->scripture ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $schedule->involved_members ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.pks_schedules.show', $schedule->id) }}"
                                                class="text-blue-600 hover:text-blue-900">Detail</a>
                                            <a href="{{ route('admin.pks_schedules.edit', $schedule->id) }}"
                                                class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <button @click="openOfferingModal({{ $schedule->id }})"
                                                class="text-yellow-600 hover:text-yellow-900">Persembahan</button>
                                            <form action="{{ route('admin.pks_schedules.destroy', $schedule->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada
                                            jadwal PKS.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Modal Persembahan Keren + Total Rp --}}
                        <div x-show="isOpen" x-transition.opacity x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                            <div x-data="{ total: 0 }" x-init="total = families.reduce((sum, f) => sum + Number(f.offering || 0), 0)"
                                class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 transform transition-transform duration-300 scale-90"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90">

                                <h3 class="text-2xl font-bold mb-4 text-center">Persembahan Keluarga</h3>
                                <form @submit.prevent="submitOffering">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <template x-for="(family, index) in families" :key="index">
                                            <div class="bg-gray-50 rounded-lg p-4 shadow hover:shadow-md transition">
                                                <p class="font-semibold mb-2" x-text="family.family_name"></p>
                                                <input type="number" x-model="family.offering" min="0"
                                                    @input="total = families.reduce((sum,f)=>sum+Number(f.offering||0),0)"
                                                    class="border rounded p-2 w-full focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Total Persembahan --}}
                                    <div class="mt-4 text-right font-semibold text-lg">
                                        Total: <span x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                                    </div>

                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" @click="close()"
                                            class="px-5 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Batal</button>
                                        <button type="submit"
                                            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $schedules->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- AlpineJS + Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function offeringModal() {
            return {
                isOpen: false,
                scheduleId: null,
                families: [],

                openOfferingModal(id) {
                    this.scheduleId = id;
                    axios.get(`/admin/pks_schedules/${id}/families`)
                        .then(res => {
                            this.families = res.data.map(f => ({
                                ...f,
                                offering: f.offering || 0
                            }));
                            this.isOpen = true;
                        })
                        .catch(err => console.error(err));
                },

                close() {
                    this.isOpen = false;
                    this.families = [];
                },

                submitOffering() {
                    axios.post(`/admin/pks_schedules/${this.scheduleId}/update-offering`, {
                            families: this.families.reduce((acc, f) => {
                                acc[f.id] = f.offering;
                                return acc;
                            }, {})
                        })
                        .then(() => {
                            alert('Persembahan berhasil diperbarui!');
                            location.reload();
                        })
                        .catch(() => alert('Terjadi kesalahan!'));
                }
            }
        }
    </script>
@endsection
