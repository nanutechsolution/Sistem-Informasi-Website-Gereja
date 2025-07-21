<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ministry; // Pastikan model Ministry di-import
use App\Models\Member;   // Pastikan model Member di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class MinistryController extends Controller
{
    /**
     * Tampilkan daftar semua pelayanan.
     */
    public function index()
    {
        $ministries = Ministry::latest()->paginate(10); // Urutkan berdasarkan yang terbaru ditambahkan

        return view('admin.ministries.index', compact('ministries'));
    }

    /**
     * Tampilkan form untuk membuat pelayanan baru.
     */
    public function create()
    {
        return view('admin.ministries.create');
    }

    /**
     * Simpan pelayanan baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:ministries,name',
                'description' => 'nullable|string',
            ]);

            Ministry::create($validatedData);

            return redirect()->route('admin.ministries.index')->with('success', 'Pelayanan berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing Ministry:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail pelayanan dan anggota di dalamnya.
     * Ini akan berfungsi sebagai halaman manajemen anggota untuk pelayanan tertentu.
     */
    public function show(Ministry $ministry)
    {
        // Load members yang tergabung dalam pelayanan ini
        $ministry->load('members');

        // Ambil daftar anggota yang BELUM tergabung dalam pelayanan ini
        $availableMembers = Member::whereDoesntHave('ministryMembers', function ($query) use ($ministry) {
            $query->where('ministry_id', $ministry->id);
        })->orderBy('full_name')->get();

        return view('admin.ministries.show', compact('ministry', 'availableMembers'));
    }

    /**
     * Tampilkan form untuk mengedit pelayanan.
     */
    public function edit(Ministry $ministry)
    {
        return view('admin.ministries.edit', compact('ministry'));
    }

    /**
     * Perbarui pelayanan di database.
     */
    public function update(Request $request, Ministry $ministry)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:ministries,name,' . $ministry->id,
                'description' => 'nullable|string',
            ]);

            $ministry->update($validatedData);

            return redirect()->route('admin.ministries.index')->with('success', 'Pelayanan berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating Ministry:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus pelayanan dari database.
     */
    public function destroy(Ministry $ministry)
    {
        try {
            $ministry->delete(); // Ini akan menghapus entri di ministry_members juga karena onDelete('cascade') pada pivot table
            return redirect()->route('admin.ministries.index')->with('success', 'Pelayanan berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Ministry:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    // --- Fungsionalitas Manajemen Anggota di dalam Pelayanan ---

    /**
     * Tambahkan anggota ke pelayanan.
     */
    public function addMember(Request $request, Ministry $ministry)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'role' => 'nullable|string|max:255',
            'joined_date' => 'nullable|date',
        ]);

        // Cek apakah anggota sudah ada di pelayanan ini untuk mencegah duplikasi
        if ($ministry->members()->where('member_id', $request->member_id)->exists()) {
            return redirect()->back()->with('error', 'Anggota ini sudah terdaftar dalam pelayanan ini.');
        }

        $ministry->members()->attach($request->member_id, [
            'role' => $request->role,
            'joined_date' => $request->joined_date ?? now(),
        ]);

        return redirect()->route('admin.ministries.show', $ministry->id)->with('success', 'Anggota berhasil ditambahkan ke pelayanan!');
    }

    /**
     * Hapus anggota dari pelayanan.
     */
    public function removeMember(Ministry $ministry, Member $member)
    {
        // Pastikan anggota ini memang tergabung dalam pelayanan ini
        if (!$ministry->members()->where('member_id', $member->id)->exists()) {
            abort(404, 'Anggota tidak ditemukan dalam pelayanan ini.');
        }

        $ministry->members()->detach($member->id);

        return redirect()->route('admin.ministries.show', $ministry->id)->with('success', 'Anggota berhasil dihapus dari pelayanan!');
    }

    /**
     * Tampilkan form untuk mengedit peran anggota dalam pelayanan.
     */
    public function editMemberRole(Ministry $ministry, Member $member)
    {
        $pivotData = $ministry->members()->where('member_id', $member->id)->first()->pivot;
        return view('admin.ministries.edit_member_role', compact('ministry', 'member', 'pivotData'));
    }

    /**
     * Perbarui peran anggota dalam pelayanan.
     */
    public function updateMemberRole(Request $request, Ministry $ministry, Member $member)
    {
        $request->validate([
            'role' => 'nullable|string|max:255',
            'joined_date' => 'nullable|date',
        ]);

        $ministry->members()->updateExistingPivot($member->id, [
            'role' => $request->role,
            'joined_date' => $request->joined_date ?? now(),
        ]);

        return redirect()->route('admin.ministries.show', $ministry->id)->with('success', 'Peran anggota berhasil diperbarui!');
    }
}
