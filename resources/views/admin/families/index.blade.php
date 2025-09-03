@extends('layouts.admin.app')

@section('title', '| Manajemen Keluarga Jemaat')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Manajemen Keluarga Jemaat') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="pksModal()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-2xl font-extrabold text-gray-800 dark:text-white">Daftar Keluarga</h3>
                        <a href="{{ route('admin.families.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Keluarga Baru
                        </a>
                    </div>

                    {{-- Flash Messages --}}
                    @if (session('success'))
                        <div
                            class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 dark:bg-green-200 dark:text-green-900">
                            <strong>Sukses!</strong> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div
                            class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 dark:bg-red-200 dark:text-red-900">
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    @endif

                    {{-- Tabel Keluarga --}}
                    <div x-data="pksModal(@json($families))" class="overflow-x-auto rounded-lg border dark:border-gray-700">
                        <div class="mb-4">
                            <input type="text" placeholder="Cari Nama Keluarga..." x-model="searchTerm"
                                class="w-full border rounded-md p-2">
                        </div>

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Nama Keluarga</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Kepala Keluarga</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Jumlah Anggota</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($families as $family)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $family->family_name ?? $family->headMember->full_name . ' Family' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $family->headMember->full_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $family->members->count() }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right space-x-2">
                                            <a href="{{ route('admin.families.show', $family->id) }}"
                                                class="text-green-600 hover:text-green-800 dark:hover:text-green-400">Kelola</a>
                                            <a href="{{ route('admin.families.edit', $family->id) }}"
                                                class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400">Edit</a>
                                            <a href="#"
                                                @click.prevent="openModal({{ $family->id }}, '{{ $family->headMember->full_name }}')"
                                                class="text-indigo-600 hover:text-indigo-800 dark:hover:text-indigo-400">Tambah
                                                Jadwal PKS</a>
                                            <form action="{{ route('admin.families.destroy', $family->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Yakin ingin hapus keluarga ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 dark:hover:text-red-400">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">Belum ada
                                            keluarga terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Modal PKS --}}
                    <div x-show="isOpen" x-transition.opacity x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-auto">
                        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 my-8 overflow-hidden flex flex-col">
                            {{-- Header --}}
                            <div class="px-6 py-4 bg-blue-600 text-white flex justify-between items-center">
                                <h3 class="text-xl font-bold">Tambah Jadwal PKS</h3>
                                <button @click="closeModal()" class="text-white hover:text-gray-200">&times;</button>
                            </div>
                            {{-- Body --}}
                            <div class="p-6 overflow-y-auto max-h-[70vh] space-y-4">
                                <form @submit.prevent="submitForm" class="space-y-4">
                                    <input type="hidden" x-model="family_id">
                                    <div>
                                        <label class="block text-sm font-medium">Nama Keluarga</label>
                                        <input type="text" x-model="family_name" readonly
                                            class="mt-1 block w-full border-gray-300 rounded-md p-2 bg-gray-100">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Tanggal</label>
                                        <input type="date" x-model="date"
                                            class="mt-1 block w-full border-gray-300 rounded-md p-2" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Waktu</label>
                                        <select x-model="time" required class="border rounded p-2 w-full">
                                            <option value="">-- Pilih Waktu --</option>
                                            @for ($h = 0; $h < 24; $h++)
                                                @for ($m = 0; $m < 60; $m += 30)
                                                    @php
                                                        $val = sprintf('%02d:%02d', $h, $m);
                                                    @endphp
                                                    <option value="{{ $val }}">{{ $val }}</option>
                                                @endfor
                                            @endfor
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Pemimpin PKS</label>
                                        <select x-model="leader_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md p-2">
                                            <option value="">-- Silakan pilih pemimpin PKS --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium">Firman Tuhan</label>
                                        <input type="text" x-model="scripture" placeholder="Contoh: Yoh 4:3"
                                            class="mt-1 block w-full border-gray-300 rounded-md p-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium">Anggota Terlibat</label>
                                        <textarea x-model="involved_members" placeholder="Pisahkan dengan koma"
                                            class="mt-1 block w-full border-gray-300 rounded-md p-2 resize-none h-24"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="closeModal()"
                                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $families->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AlpineJS + Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function pksModal() {
            return {
                isOpen: false,
                family_id: null,
                family_name: '',
                date: '',
                time: '',
                leader_id: '',
                scripture: '',
                involved_members: '',


                openModal(familyId, familyName) {
                    this.family_id = familyId;
                    this.family_name = familyName || 'Family';
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                    this.date = '';
                    this.time = '';
                    this.leader_id = '';
                    this.scripture = '';
                    this.involved_members = '';
                },

                async submitForm() {
                    try {
                        const timePattern = /^([0-1]\d|2[0-3]):([0-5]\d)$/;

                        if (!this.family_id || !this.date || !this.time || !this.leader_id) {
                            alert("Tanggal, Waktu, dan Pemimpin harus diisi!");
                            return;
                        }
                        if (!timePattern.test(this.time)) {
                            alert("Format waktu tidak valid! Gunakan HH:MM (24 jam).");
                            return;
                        }

                        const response = await axios.post("{{ route('admin.pks_schedules.store') }}", {
                            family_id: this.family_id,
                            date: this.date,
                            time: this.time,
                            leader_id: this.leader_id,
                            scripture: this.scripture,
                            involved_members: this.involved_members
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (response.status === 200) {
                            alert('Jadwal PKS berhasil disimpan!');
                            this.closeModal();
                            location.reload();
                        }
                    } catch (error) {
                        if (error.response && error.response.status === 422) {
                            // Ambil semua pesan error
                            const messages = Object.values(error.response.data.errors)
                                .flat()
                                .join("\n");
                            alert(messages);
                        } else if (error.response && error.response.data.message) {
                            // Custom validation dari controller
                            alert(error.response.data.message);
                        } else {
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    }

                }
            }
        }
    </script>
@endsection
