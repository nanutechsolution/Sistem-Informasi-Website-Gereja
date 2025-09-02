<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PksSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PksScheduleController extends Controller
{
    public function index()
    {
        $schedules = PksSchedule::latest()->paginate(10);
        return view('admin.pks_schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.pks_schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'day_of_week'   => 'required|string|max:50',
            'date'          => 'required|date',
            'time'          => 'required',
            'location'      => 'required|string|max:255',
            'leader_name'   => 'required|string|max:255',
        ]);

        PksSchedule::create($request->all());

        return redirect()->route('pks_schedules.index')
            ->with('success', 'Jadwal PKS berhasil ditambahkan!');
    }

    public function show(PksSchedule $pksSchedule)
    {
        return view('admin.pks_schedules.show',  ['schedule' => $pksSchedule]);
    }

    public function edit(PksSchedule $pks_schedule)
    {
        return view('admin.pks_schedules.edit', [
            'schedule' => $pks_schedule
        ]);
    }

    public function update(Request $request, PksSchedule $pksSchedule)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'day_of_week'   => 'required|string|max:50',
            'date'          => 'required|date',
            'time'          => 'required',
            'location'      => 'required|string|max:255',
            'leader_name'   => 'required|string|max:255',
        ]);

        $pksSchedule->update($request->all());

        return redirect()->route('admin.pks_schedules.index')
            ->with('success', 'Jadwal PKS berhasil diperbarui!');
    }

    public function destroy(PksSchedule $pksSchedule)
    {
        $pksSchedule->delete();
        return redirect()->route('admin.pks_schedules.index')
            ->with('success', 'Jadwal PKS berhasil dihapus!');
    }

    public function calendar()
    {
        return view('admin.pks_schedules.calendar');
    }

    public function calendarData(Request $request)
    {
        $query = PksSchedule::query();

        if ($request->filled('leader')) {
            $query->where('leader_name', $request->leader);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('activity')) {
            $query->where('activity_name', 'like', '%' . $request->activity . '%');
        }


        $events = PksSchedule::where('is_active', 1)->get()->map(fn($s) => [
            'id'    => $s->id,
            'title' => $s->activity_name,
            'start' => $s->start_date_time->toDateTimeString(),
            'end'   => $s->end_date_time->toDateTimeString(),
            'url'   => route('admin.pks_schedules.show', $s->id), // 👈 langsung ke show
            'extendedProps' => [
                'location' => $s->location,
                'leader'   => $s->leader_name,
                'desc'     => $s->description,
            ],
            'color' => '#3788d8',
        ]);

        return response()->json($events);
    }
}