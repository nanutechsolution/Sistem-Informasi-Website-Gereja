<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\PksSchedule;
use App\Models\User;
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
            'family_id'        => 'required|exists:families,id',
            'date'             => 'required|date',
            'time'             => 'required',
            'leader_id'        => 'required|exists:users,id',
            'scripture'        => 'nullable|string|max:255',
            'involved_members' => 'nullable|string',
        ]);
        $day_of_week = \Carbon\Carbon::parse($request->date)->format('l');
        PksSchedule::create([
            'family_id'        => $request->family_id,
            'date'             => $request->date,
            'time'             => $request->time,
            'leader_id'        => $request->leader_id,
            'scripture'        => $request->scripture,
            'involved_members' => $request->involved_members,
            'is_active'        => 1, // default aktif
            'day_of_week'      => $day_of_week,
        ]);

        return redirect()->route('admin.families.index')
            ->with('success', 'Jadwal PKS berhasil ditambahkan!');
    }

    public function show(PksSchedule $pksSchedule)
    {
        return view('admin.pks_schedules.show',  ['schedule' => $pksSchedule]);
    }

    public function edit(PksSchedule $pks_schedule)
    {
        $users = User::all();
        $families = Family::all();

        return view('admin.pks_schedules.edit', [
            'schedule' => $pks_schedule,
            'users' => $users,
            'families' => $families,
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
        $query = PksSchedule::with(['leader', 'family']); // relasi

        if ($request->filled('leader')) {
            $query->whereHas('leader', fn($q) => $q->where('name', $request->leader));
        }

        if ($request->filled('family')) { // kalau family dianggap lokasi
            $query->whereHas('family', fn($q) => $q->where('name', $request->family));
        }

        $events = $query->where('is_active', 1)->get()->map(fn($s) => [
            'id'    => $s->id,
            'title' => $s->scripture ?? 'PKS',
            'start' => $s->date . ' ' . $s->time,
            'end'   => $s->date . ' ' . $s->time,
            'url'   => route('admin.pks_schedules.show', $s->id),
            'extendedProps' => [
                'leader'   => $s->leader ? $s->leader->name : '-',
                'location' => $s->family ? $s->family->name : '-',
                'desc'     => $s->scripture ?? '-',
            ],
            'color' => '#3788d8',
        ]);

        return response()->json($events);
    }
}