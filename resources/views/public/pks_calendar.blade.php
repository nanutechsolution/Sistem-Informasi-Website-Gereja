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

        {{-- Legend --}}
        <div class="mb-4 flex gap-4 justify-center flex-wrap">
            @php
                $colors = [
                    'Gereja Utama' => '#3b82f6',
                    'Balai Jemaat' => '#f97316',
                    'Gedung Serbaguna' => '#10b981',
                    'Lainnya' => '#8b5cf6',
                ];
            @endphp
            @foreach ($colors as $loc => $color)
                <div class="flex items-center gap-1">
                    <span class="w-4 h-4 rounded" style="background-color: {{ $color }}"></span>
                    <span class="text-sm">{{ $loc }}</span>
                </div>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Calendar --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
                {{-- Custom Toolbar --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
                    <div class="flex gap-2 mb-2 md:mb-0">
                        <button id="prev"
                            class="px-3 py-1 rounded bg-blue-500 text-white font-semibold hover:bg-blue-600">‹</button>
                        <button id="next"
                            class="px-3 py-1 rounded bg-blue-500 text-white font-semibold hover:bg-blue-600">›</button>
                        <button id="today"
                            class="px-3 py-1 rounded bg-green-500 text-white font-semibold hover:bg-green-600">Hari
                            Ini</button>
                    </div>
                    <div id="calendarTitle" class="text-lg font-bold text-center md:text-left mb-2 md:mb-0"></div>
                    <div class="flex gap-2">
                        <button id="monthView" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Bulan</button>
                        <button id="weekView" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Minggu</button>
                        <button id="dayView" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300">Hari</button>
                    </div>
                </div>

                <div id="calendar" class="bg-white rounded-lg"></div>
            </div>

            {{-- Upcoming list --}}
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex justify-between items-center mb-2 lg:hidden">
                    <h3 class="text-xl font-semibold">Upcoming PKS</h3>
                    <button id="toggleUpcoming" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">☰</button>
                </div>
                <div id="upcomingContainer" class="lg:block hidden">
                    <h3 class="text-xl font-semibold mb-4 hidden lg:block">Upcoming PKS</h3>
                    <ul id="upcomingList" class="space-y-3"></ul>
                </div>
            </div>
        </div>
    </div>

    {{-- FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const upcomingEl = document.getElementById('upcomingList');
            const upcomingContainer = document.getElementById('upcomingContainer');
            const toggleUpcoming = document.getElementById('toggleUpcoming');

            const locationColors = {
                "Gereja Utama": "#3b82f6",
                "Balai Jemaat": "#f97316",
                "Gedung Serbaguna": "#10b981",
                "Lainnya": "#8b5cf6"
            };

            toggleUpcoming?.addEventListener('click', () => {
                upcomingContainer.classList.toggle('hidden');
            });

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false,
                height: 'auto',
                dayMaxEvents: true,
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch("{{ route('public.pks_calendar.data') }}?leader=" + document.getElementById(
                                'leader').value +
                            "&location=" + document.getElementById('location').value)
                        .then(res => res.json())
                        .then(data => {
                            const events = data.map(ev => ({
                                id: ev.id,
                                title: ev.title,
                                start: ev.start,
                                end: ev.end,
                                extendedProps: {
                                    leader: ev.leader,
                                    location: ev.location,
                                    desc: ev.desc
                                },
                                backgroundColor: locationColors[ev.location] ||
                                    locationColors["Lainnya "],
                                borderColor: locationColors[ev.location] ||
                                    locationColors["Lainnya"],
                                textColor: "#fff"
                            }));
                            successCallback(events);
                            updateUpcomingList(
                                events); // **langsung update upcoming saat pertama load**
                        })
                        .catch(err => {
                            alert('Gagal load data jadwal!');
                            failureCallback(err);
                        });
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
                eventMouseEnter: function(info) {
                    info.el.setAttribute('title', info.event.extendedProps.leader + " - " + info.event
                        .extendedProps.location);
                },
                datesSet: function() {
                    document.getElementById('calendarTitle').innerText = calendar.view.title;
                }
            });

            calendar.render();
            document.getElementById('calendarTitle').innerText = calendar.view.title;

            // Filter change
            document.getElementById('leader').addEventListener('change', () => calendar.refetchEvents());
            document.getElementById('location').addEventListener('change', () => calendar.refetchEvents());

            // Custom toolbar
            document.getElementById('prev').addEventListener('click', () => calendar.prev());
            document.getElementById('next').addEventListener('click', () => calendar.next());
            document.getElementById('today').addEventListener('click', () => calendar.today());
            document.getElementById('monthView').addEventListener('click', () => calendar.changeView(
                'dayGridMonth'));
            document.getElementById('weekView').addEventListener('click', () => calendar.changeView(
                'timeGridWeek'));
            document.getElementById('dayView').addEventListener('click', () => calendar.changeView('timeGridDay'));

            // Function: update upcoming list
            function updateUpcomingList(events = null) {
                const allEvents = events || calendar.getEvents();
                const upcoming = allEvents
                    .filter(ev => ev.start >= new Date())
                    .sort((a, b) => a.start - b.start)
                    .slice(0, 5);

                upcomingEl.innerHTML = '';
                upcoming.forEach(ev => {
                    const li = document.createElement('li');
                    li.className = "p-3 border rounded hover:bg-blue-50 transition
                    cursor - pointer ";
                    li.innerHTML = < div class = "font-semibold" > $ {
                            ev.title
                        } <
                        /div> <div class="text-sm text-gray-600">${ev.extendedProps.leader} - ${ev.extendedProps.location}</div >
                        <
                        div class = "text-sm text-gray-500" > $ {
                            ev.start.toLocaleDateString('id-ID', {
                                weekday: 'short',
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            })
                        } < /div> ;
                    li.addEventListener('click', () => {
                        calendar.gotoDate(ev.start); // scroll ke tanggal
                        ev.setProp('backgroundColor', '#f43f5e'); // highlight sementara
                        setTimeout(() => {
                            ev.setProp('backgroundColor', locationColors[ev.extendedProps
                                .location] || locationColors["Lainnya"]);
                        }, 1000);
                        ev.click(); // buka detail
                    });
                    upcomingEl.appendChild(li);
                });
            }
        });
    </script>
@endsection
