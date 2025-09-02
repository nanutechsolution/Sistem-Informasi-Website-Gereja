@extends('layouts.app')

@section('title', 'Kalender PKS Publik')

@section('content')
    <div class="py-6 max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold mb-6 text-center">📅 Kalender PKS</h2>

        {{-- Filter --}}
        <div class="mb-6 flex flex-col md:flex-row gap-4 justify-center items-center">
            <div class="w-full md:w-1/3">
                <label for="leader" class="block font-medium mb-1">Pemimpin PKS</label>
                <select id="leader"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Semua Pemimpin --</option>
                    @foreach (\App\Models\PksSchedule::select('leader_name')->distinct()->get() as $item)
                        <option value="{{ $item->leader_name }}">{{ $item->leader_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/3">
                <label for="location" class="block font-medium mb-1">Lokasi</label>
                <select id="location"
                    class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Semua Lokasi --</option>
                    @foreach (\App\Models\PksSchedule::select('location')->distinct()->get() as $item)
                        <option value="{{ $item->location }}">{{ $item->location }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Custom Toolbar --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
            <div class="flex gap-2">
                <button id="prev"
                    class="px-3 py-1 rounded bg-blue-500 text-white font-semibold hover:bg-blue-600">‹</button>
                <button id="next"
                    class="px-3 py-1 rounded bg-blue-500 text-white font-semibold hover:bg-blue-600">›</button>
                <button id="today"
                    class="px-3 py-1 rounded bg-green-500 text-white font-semibold hover:bg-green-600">Hari Ini</button>
            </div>
            <div id="calendarTitle" class="text-lg font-bold text-center md:text-left"></div>
            <div class="flex gap-2">
                <button id="monthView" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Bulan</button>
                <button id="weekView" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Minggu</button>
                <button id="dayView" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Hari</button>
            </div>
        </div>

        {{-- Calendar --}}
        <div id="calendar" class="bg-white rounded-lg shadow p-4"></div>
    </div>

    {{-- FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false, // kita pakai custom toolbar
                height: 'auto',
                events: {
                    url: "{{ route('public.pks_calendar.data') }}",
                    method: 'GET',
                    extraParams: function() {
                        return {
                            leader: document.getElementById('leader').value,
                            location: document.getElementById('location').value
                        };
                    },
                    failure: function() {
                        alert('Gagal load data jadwal!');
                    }
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    const e = info.event;

                    Swal.fire({
                        title: e.title,
                        html: `
                    <p><strong>Lokasi:</strong> ${e.extendedProps.location || '-'}</p>
                    <p><strong>Dipimpin oleh:</strong> ${e.extendedProps.leader || '-'}</p>
                    <p><strong>Deskripsi:</strong> ${e.extendedProps.desc || '-'}</p>
                `,
                        icon: 'info',
                        confirmButtonText: 'Tutup'
                    });
                },
                dayMaxEvents: true
            });

            calendar.render();
            // Set default title pertama kali
            document.getElementById('calendarTitle').innerText = calendar.view.title;


            // Refetch events on filter change
            document.getElementById('leader').addEventListener('change', () => calendar.refetchEvents());
            document.getElementById('location').addEventListener('change', () => calendar.refetchEvents());

            // Custom toolbar buttons
            document.getElementById('prev').addEventListener('click', () => calendar.prev());
            document.getElementById('next').addEventListener('click', () => calendar.next());
            document.getElementById('today').addEventListener('click', () => calendar.today());
            document.getElementById('monthView').addEventListener('click', () => calendar.changeView(
                'dayGridMonth'));
            document.getElementById('weekView').addEventListener('click', () => calendar.changeView(
                'timeGridWeek'));
            document.getElementById('dayView').addEventListener('click', () => calendar.changeView('timeGridDay'));

            // Update title on view change
            calendar.on('datesSet', function() {
                document.getElementById('calendarTitle').innerText = calendar.view.title;
            });
        });
    </script>
@endsection
