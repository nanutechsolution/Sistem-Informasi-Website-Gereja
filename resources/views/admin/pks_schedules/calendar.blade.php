@extends('layouts.admin.app')

@section('title', 'Kalender Jadwal PKS')

@section('content')

    <div class="py-6 max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">📅 Kalender Jadwal PKS</h2>
        <div class="mb-3 flex gap-4">
            <div>
                <label for="leader">Leader:</label>
                <select id="leader" class="border rounded p-1">
                    <option value="">-- Semua Leader --</option>
                    @foreach (App\Models\PksSchedule::select('leader_name')->distinct()->get() as $item)
                        <option value="{{ $item->leader_name }}">{{ $item->leader_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="location">Location:</label>
                <select id="location" class="border rounded p-1">
                    <option value="">-- Semua Lokasi --</option>
                    @foreach (App\Models\PksSchedule::select('location')->distinct()->get() as $item)
                        <option value="{{ $item->location }}">{{ $item->location }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="activity">Activity:</label>
                <input type="text" id="activity" placeholder="Cari activity..." class="border rounded p-1" />
            </div>
        </div>

        <div id="calendar"></div>
    </div>

    {{-- FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: "{{ route('admin.pks_schedules.calendar.data') }}",
                    method: 'GET',
                    extraParams: function() {
                        return {
                            leader: document.getElementById('leader').value,
                            location: document.getElementById('location').value,
                            activity: document.getElementById('activity').value
                        };
                    },
                    failure: function() {
                        alert('Gagal load data jadwal!');
                    }
                },
                eventClick: function(info) {
                    window.location.href = info.event.url; // 👈 redirect ke halaman show
                }

            });
            calendar.render();

            // Reload saat filter berubah
            document.getElementById('leader').addEventListener('change', function() {
                calendar.refetchEvents();
            });
            document.getElementById('location').addEventListener('change', function() {
                calendar.refetchEvents();
            });

            // Search activity dengan debounce
            let typingTimer;
            let debounce = 500; // ms
            document.getElementById('activity').addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    calendar.refetchEvents();
                }, debounce);
            });
        });
    </script>

@endsection
