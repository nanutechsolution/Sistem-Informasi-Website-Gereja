<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class FamilyController extends Controller
{
    /**
     * Tampilkan daftar semua keluarga.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $families = Family::with('headMember', 'members')
            ->when($search, function ($query, $search) {
                $query->where('family_name', 'like', "%{$search}%")
                    ->orWhereHas('headMember', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('members', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // <-- penting biar pagination bawa query search

        $users = User::all();

        return view('admin.families.index', compact('families', 'users'));
    }

    /**
     * Tampilkan form untuk membuat keluarga baru.
     */
    public function create()
    {
        // Ambil semua anggota untuk dropdown Kepala Keluarga
        $members = Member::orderBy('full_name')->get();
        return view('admin.families.create', compact('members'));
    }

    /**
     * Simpan keluarga baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'family_name' => 'nullable|string|max:255',
                'head_member_id' => 'required|exists:members,id|unique:families,head_member_id',
            ]);
            $family = Family::create($validatedData);

            // Otomatis tambahkan kepala keluarga sebagai anggota keluarga
            $family->members()->attach($validatedData['head_member_id'], ['relationship' => 'Kepala Keluarga']);

            return redirect()->route('admin.families.index')->with('success', 'Keluarga berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing Family:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail keluarga dan anggota di dalamnya.
     */
    public function show(Family $family)
    {
        $family->load('members'); // Load anggota keluarga
        // Anggota yang belum termasuk dalam keluarga ini
        $availableMembers = Member::whereDoesntHave('families', function ($query) use ($family) {
            $query->where('family_id', $family->id);
        })->orderBy('full_name')->get();

        $relationships = ['Suami', 'Istri', 'Anak', 'Orang Tua', 'Saudara Kandung', 'Lain-lain']; // Opsi hubungan
        return view('admin.families.show', compact('family', 'availableMembers', 'relationships'));
    }

    /**
     * Tampilkan form untuk mengedit keluarga.
     */
    public function edit(Family $family)
    {
        $members = Member::orderBy('full_name')->get();
        return view('admin.families.edit', compact('family', 'members'));
    }

    /**
     * Perbarui keluarga di database.
     */
    public function update(Request $request, Family $family)
    {
        try {
            $validatedData = $request->validate([
                'family_name' => 'nullable|string|max:255',
                // Izinkan head_member_id unik kecuali ID keluarga ini
                'head_member_id' => 'required|exists:members,id|unique:families,head_member_id,' . $family->id,
            ]);

            $oldHead = $family->head_member_id;
            $family->update($validatedData);

            // Jika kepala keluarga berubah, perbarui relationship di pivot table
            if ($oldHead != $family->head_member_id) {
                // Hapus relasi 'Kepala Keluarga' dari anggota lama jika dia hanya kepala keluarga di sini
                // Cek jika anggota lama masih di keluarga ini
                if ($family->members()->where('member_id', $oldHead)->wherePivot('relationship', 'Kepala Keluarga')->exists()) {
                    $family->members()->updateExistingPivot($oldHead, ['relationship' => 'Mantan Kepala Keluarga']);
                }
                // Tambahkan atau update anggota baru sebagai Kepala Keluarga
                $family->members()->syncWithoutDetaching([$family->head_member_id => ['relationship' => 'Kepala Keluarga']]);
            }


            return redirect()->route('admin.families.index')->with('success', 'Keluarga berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating Family:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus keluarga dari database.
     */
    public function destroy(Family $family)
    {
        try {
            $family->delete(); // Ini akan menghapus entri di family_members juga karena onDelete('cascade')
            return redirect()->route('admin.families.index')->with('success', 'Keluarga berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Family:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    // --- Fungsionalitas Manajemen Anggota Keluarga ---

    /**
     * Tambahkan anggota ke keluarga.
     */
    public function addMemberToFamily(Request $request, Family $family)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'relationship' => 'required|string|max:255',
        ]);

        // Cek apakah anggota sudah ada di keluarga ini
        if ($family->members()->where('member_id', $request->member_id)->exists()) {
            return redirect()->back()->with('error', 'Anggota ini sudah terdaftar dalam keluarga ini.');
        }

        // Cek apakah anggota yang ditambahkan adalah kepala keluarga yang sudah ada
        if ($request->member_id == $family->head_member_id) {
            return redirect()->back()->with('error', 'Anggota ini adalah kepala keluarga dan sudah otomatis terdaftar.');
        }

        $existingFamilyMember = DB::table('family_members')->where('member_id', $request->member_id)->where('family_id', '!=', $family->id)->first();
        if ($existingFamilyMember) {
            return redirect()->back()->with('error', 'Anggota ini sudah terdaftar dikeluarga lain.');
        }

        $family->members()->attach($request->member_id, ['relationship' => $request->relationship]);

        return redirect()->route('admin.families.show', $family->id)->with('success', 'Anggota berhasil ditambahkan ke keluarga!');
    }

    /**
     * Hapus anggota dari keluarga.
     */
    public function removeMemberFromFamily(Family $family, Member $member)
    {
        // Tidak boleh menghapus kepala keluarga dari daftar anggota keluarga langsung
        if ($family->head_member_id === $member->id) {
            return redirect()->back()->with('error', 'Kepala keluarga tidak dapat dihapus dari daftar anggota keluarga. Ubah kepala keluarga terlebih dahulu.');
        }

        $family->members()->detach($member->id);

        return redirect()->route('admin.families.show', $family->id)->with('success', 'Anggota berhasil dihapus dari keluarga!');
    }

    /**
     * Tampilkan form untuk mengedit hubungan anggota dalam keluarga.
     */
    public function editMemberRelationship(Family $family, Member $member)
    {
        $pivotData = $family->members()->where('member_id', $member->id)->first()->pivot;
        $relationships = ['Suami', 'Istri', 'Anak', 'Orang Tua', 'Saudara Kandung', 'Lain-lain'];
        return view('admin.families.edit_member_relationship', compact('family', 'member', 'pivotData', 'relationships'));
    }

    /**
     * Perbarui hubungan anggota dalam keluarga.
     */
    public function updateMemberRelationship(Request $request, Family $family, Member $member)
    {
        $request->validate([
            'relationship' => 'required|string|max:255',
        ]);

        // Tidak boleh mengubah hubungan Kepala Keluarga melalui form ini
        if ($family->head_member_id === $member->id && $request->relationship !== 'Kepala Keluarga') {
            return redirect()->back()->with('error', 'Peran Kepala Keluarga tidak dapat diubah di sini. Silakan ubah melalui detail keluarga.');
        }

        $family->members()->updateExistingPivot($member->id, ['relationship' => $request->relationship]);

        return redirect()->route('admin.families.show', $family->id)->with('success', 'Hubungan anggota berhasil diperbarui!');
    }
}
