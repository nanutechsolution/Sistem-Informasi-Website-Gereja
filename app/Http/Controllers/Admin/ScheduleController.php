<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule; // Pastikan model Schedule di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Untuk menangani error validasi
use Carbon\Carbon; // Untuk format tanggal/waktu

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar semua jadwal.
     */
    public function index()
    {
        // Ambil semua jadwal, urutkan berdasarkan tanggal dan waktu terbaru
        $schedules = Schedule::orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10); // Menambahkan pagination

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Tampilkan form untuk membuat jadwal baru.
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Simpan jadwal baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i', // Format jam:menit (HH:MM)
                'location' => 'nullable|string|max:255',
            ]);

            // Pastikan format waktu sudah benar sebelum disimpan
            $time = Carbon::parse($request->time)->format('H:i:s'); // Simpan sebagai H:i:s

            Schedule::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $time,
                'location' => $request->location,
            ]);

            return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Tampilkan detail jadwal (opsional untuk admin).
     */
    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Tampilkan form untuk mengedit jadwal.
     */
    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Perbarui jadwal di database.
     */
    public function update(Request $request, Schedule $schedule)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'location' => 'nullable|string|max:255',
            ]);

            $time = Carbon::parse($request->time)->format('H:i:s');

            $schedule->update([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $time,
                'location' => $request->location,
            ]);

            return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Hapus jadwal dari database.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
