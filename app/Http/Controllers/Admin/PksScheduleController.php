<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\PksSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PksScheduleController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search');

        $query = PksSchedule::with(['leader', 'families'])
            ->where('is_active', 1)
            ->orderBy('date', 'asc');

        if (!$user->hasAnyRole(['admin', 'pendeta', 'bendahara'])) {
            $query->where('leader_id', $user->id);
        }

        if ($search) {
            $query->whereHas('families', function ($q) use ($search) {
                $q->where('family_name', 'like', "%{$search}%");
            });
        }

        $schedules = $query->paginate(10)->withQueryString();

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
            'leader_id'        => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = PksSchedule::where('leader_id', $value)
                        ->where('date', $request->date)
                        ->exists();
                    if ($exists) {
                        $fail('Pemimpin yang sama sudah dijadwalkan pada tanggal ini.');
                    }
                }
            ],
            'scripture'        => 'nullable|string|max:255',
            'involved_members' => 'nullable|string',
            'offering'         => 'nullable|numeric',
        ]);

        $day_of_week = \Carbon\Carbon::parse($request->date)->format('l');

        $schedule = PksSchedule::create([
            'date'             => $request->date,
            'time'             => $request->time,
            'leader_id'        => $request->leader_id,
            'scripture'        => $request->scripture,
            'involved_members' => $request->involved_members,
            'is_active'        => 1,
            'day_of_week'      => $day_of_week,
        ]);

        $schedule->families()->attach($request->family_id, [
            'offering' => $request->offering ?? null,
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
            'family_id' => 'required|exists:families,id',
            'date' => 'required|date',
            'time' => 'required',
            'leader_id' => 'required|exists:users,id',
            'scripture' => 'nullable|string|max:255',
            'involved_members' => 'nullable|string',
            'offering' => 'nullable|numeric',
        ]);

        $day_of_week = \Carbon\Carbon::parse($request->date)->format('l');

        // Update main table
        $pksSchedule->update([
            'date' => $request->date,
            'time' => $request->time,
            'leader_id' => $request->leader_id,
            'scripture' => $request->scripture,
            'involved_members' => $request->involved_members,
            'day_of_week' => $day_of_week,
        ]);

        // Sync pivot dengan offering
        $pksSchedule->families()->sync([
            $request->family_id => ['offering' => $request->offering ?? null]
        ]);

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
        $query = PksSchedule::with(['leader', 'families']);

        if ($request->filled('leader')) {
            $query->whereHas('leader', fn($q) => $q->where('name', $request->leader));
        }

        if ($request->filled('families')) {
            $query->whereHas('families', fn($q) => $q->where('name', $request->family));
        }

        $events = $query->where('is_active', 1)->get()->map(fn($s) => [
            'id'    => $s->id,
            'title' => $s->scripture ?? 'PKS',
            'start' => $s->date . ' ' . $s->time,
            'end'   => $s->date . ' ' . $s->time,
            'url'   => route('admin.pks_schedules.show', $s->id),
            'extendedProps' => [
                'leader'   => $s->leader ? $s->leader->name : '-',
                'location' => $s->families->pluck('family_name')->implode(', ') ?: '-',
                'desc'     => $s->scripture ?? '-',
            ],
            'color' => '#3788d8',
        ]);


        return response()->json($events);
    }

    public function getFamilies(PksSchedule $schedule)
    {
        // ambil semua keluarga yang terhubung dengan jadwal ini
        $families = $schedule->families()->get()->map(function ($family) {
            return [
                'id' => $family->id,
                'family_name' => $family->family_name,
                'offering' => $family->pivot->offering,
            ];
        });

        return response()->json($families);
    }

    public function updateOffering(Request $request, PksSchedule $schedule)
    {
        $data = $request->input('families', []);

        foreach ($data as $familyId => $offering) {
            $schedule->families()->updateExistingPivot($familyId, ['offering' => $offering]);
        }
        $schedule->is_active = 0;
        $schedule->save(); // jangan lupa save()

        return response()->json(['success' => true]);
    }
}