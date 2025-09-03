@extends('layouts.app')

@section('title', 'Kalender PKS Publik')

@section('content')
    <div class="py-6 px-4 max-w-7xl mx-auto">
        <h2 class="text-3xl font-extrabold text-center mb-6">📅 Kalender PKS</h2>

        {{-- Filter --}}
        <div class="mb-6 flex flex-col md:flex-row gap-4 justify-center items-center">
            <div class="w-full md:w-1/3">
                <label for="leader" class="block font-medium mb-1">Pemimpin PKS</label>
                <select id="leader" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Semua Pemimpin --</option>
                    @foreach (\App\Models\User::orderBy('name')->get() as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/3">
                <label for="location" class="block font-medium mb-1">Lokasi / Family</label>
                <select id="location" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Semua Lokasi --</option>
                    @foreach (\App\Models\Family::orderBy('family_name')->get() as $family)
                        <option value="{{ $family->family_name }}">{{ $family->family_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Grid Kalender + Upcoming --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kalender --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
                <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                    <div class="flex gap-2">
                        <button id="prev" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">‹</button>
                        <button id="next" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">›</button>
                        <button id="today" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Hari
                            Ini</button>
                    </div>
                    <div id="calendarTitle" class="text-lg font-bold text-center flex-1"></div>
                    <div class="flex gap-2">
                        <button id="monthView" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Bulan</button>
                        <button id="weekView" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Minggu</button>
                        <button id="dayView" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Hari</button>
                    </div>
                </div>
                <div id="calendar" class="rounded-lg"></div>
            </div>

            {{-- Upcoming --}}
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-xl font-semibold mb-4">Upcoming PKS</h3>
                <ul id="upcomingList" class="space-y-3"></ul>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const upcomingEl = document.getElementById('upcomingList');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false,
                height: 'auto',
                dayMaxEvents: true,
                navLinks: true,
                nowIndicator: true,
                events: {
                    url: "{{ route('public.pks_calendar.data') }}",
                    method: 'GET',
                    extraParams: () => ({
                        leader: document.getElementById('leader').value,
                        location: document.getElementById('location').value
                    }),
                    failure: () => alert('Gagal load data jadwal!'),
                    success: (events) => updateUpcomingList(events)
                },
                eventClick: (info) => {
                    info.jsEvent.preventDefault();
                    const e = info.event;
                    Swal.fire({
                        title: e.title,
                        html: `<p><strong> PKS dirumah tangga:</strong> ${e.extendedProps.location || '-'}</p>
                       <p><strong>Pemimpin:</strong> ${e.extendedProps.leader || '-'}</p>
                       <p><strong>Firman Tuhan:</strong> ${e.extendedProps.desc || '-'}</p>
                       <p><strong>Anggota Terlibat:</strong> ${e.extendedProps.involved_members || '-'}</p>`,
                        icon: 'info',
                        confirmButtonText: 'Tutup'
                    });
                },
                datesSet: () => {
                    document.getElementById('calendarTitle').innerText = calendar.view.title;
                    updateUpcomingList();
                }
            });

            calendar.render();

            // Filter & Toolbar
            ['leader', 'location'].forEach(id => document.getElementById(id)
                .addEventListener('change', () => calendar.refetchEvents()));
            document.getElementById('prev').addEventListener('click', () => calendar.prev());
            document.getElementById('next').addEventListener('click', () => calendar.next());
            document.getElementById('today').addEventListener('click', () => calendar.today());
            document.getElementById('monthView').addEventListener('click', () => calendar.changeView(
                'dayGridMonth'));
            document.getElementById('weekView').addEventListener('click', () => calendar.changeView(
                'timeGridWeek'));
            document.getElementById('dayView').addEventListener('click', () => calendar.changeView('timeGridDay'));

            function updateUpcomingList(loadedEvents = null) {
                const events = loadedEvents || calendar.getEvents();
                const upcoming = events
                    .filter(ev => new Date(ev.start) >= new Date())
                    .sort((a, b) => new Date(a.start) - new Date(b.start))
                    .slice(0, 5);
                upcomingEl.innerHTML = '';
                upcoming.forEach(ev => {
                    const li = document.createElement('li');
                    li.className = "p-3 border rounded hover:bg-blue-50 cursor-pointer";
                    li.innerHTML = `
                <div class="font-semibold"> ${ev.title}</div>
                <div class="text-sm text-gray-600">Pemimpin: ${ev.extendedProps.leader}</div>
                <div class="text-sm text-gray-500">${new Date(ev.start).toLocaleDateString('id-ID', { weekday:'short', day:'numeric', month:'short', year:'numeric' })}</div>
                <div class="text-sm text-gray-500">Anggota Terlibat: ${ev.extendedProps.involved_members}</div>
            `;
                    li.addEventListener('click', () => {
                        calendar.gotoDate(ev.start);
                        ev.setProp('backgroundColor', '#f43f5e');
                        setTimeout(() => ev.setProp('backgroundColor', '#3788d8'), 1000);
                        ev.click();
                    });
                    upcomingEl.appendChild(li);
                });
            }
        });
    </script>
@endsection
