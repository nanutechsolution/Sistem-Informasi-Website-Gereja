<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member; // Pastikan model Member di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Untuk debugging, bisa dihapus nanti

class MemberController extends Controller
{


    /**
     * Tampilkan daftar semua anggota jemaat.
     */
    public function index()
    {
        $members = Member::latest()->paginate(10); // Urutkan berdasarkan yang terbaru ditambahkan

        return view('admin.members.index', compact('members'));
    }

    /**
     * Tampilkan form untuk membuat anggota baru.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Simpan anggota baru ke database.
     */
    public function store(Request $request)
    {
        try {
            // Log::info('Request data for Member store:', $request->all()); // Untuk debugging

            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'nik' => 'nullable|string|max:255|unique:members,nik',
                'gender' => 'nullable|string|in:Laki-laki,Perempuan',
                'date_of_birth' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'blood_type' => 'nullable|string|max:5',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:255',
                'province' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:10',
                'phone_number' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:members,email',
                'baptism_date' => 'nullable|date',
                'sidi_date' => 'nullable|date',
                'marital_status' => 'nullable|string|in:Belum Menikah,Menikah,Duda,Janda',
                'notes' => 'nullable|string',
                // 'user_id' => 'nullable|exists:users,id', // Hanya jika Anda mengaitkan dengan user login atau memilih dari dropdown
            ]);

            // Opsional: Jika Anda ingin mengaitkan dengan user yang login saat membuat data anggota
            // $validatedData['user_id'] = auth()->id();

            Member::create($validatedData);

            return redirect()->route('admin.members.index')->with('success', 'Anggota jemaat berhasil ditambahkan!');
        } catch (ValidationException $e) {
            // Log::error('Validation failed for Member store:', ['errors' => $e->errors(), 'request' => $request->all()]); // Untuk debugging
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log::error('Error storing Member:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]); // Untuk debugging
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail anggota.
     */
    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    /**
     * Tampilkan form untuk mengedit anggota.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Perbarui anggota di database.
     */
    public function update(Request $request, Member $member)
    {
        try {
            // Log::info('Request data for Member update:', $request->all()); // Untuk debugging

            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                // Gunakan Rule::unique untuk mengabaikan ID anggota yang sedang diedit
                'nik' => 'nullable|string|max:255|unique:members,nik,' . $member->id,
                'gender' => 'nullable|string|in:Laki-laki,Perempuan',
                'date_of_birth' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'blood_type' => 'nullable|string|max:5',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:255',
                'province' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:10',
                'phone_number' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:members,email,' . $member->id,
                'baptism_date' => 'nullable|date',
                'sidi_date' => 'nullable|date',
                'marital_status' => 'nullable|string|in:Belum Menikah,Menikah,Duda,Janda',
                'notes' => 'nullable|string',
                // 'user_id' => 'nullable|exists:users,id',
            ]);

            $member->update($validatedData);

            return redirect()->route('admin.members.index')->with('success', 'Data anggota jemaat berhasil diperbarui!');
        } catch (ValidationException $e) {
            // Log::error('Validation failed for Member update:', ['errors' => $e->errors(), 'request' => $request->all()]); // Untuk debugging
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log::error('Error updating Member:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]); // Untuk debugging
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus anggota dari database.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return redirect()->route('admin.members.index')->with('success', 'Anggota jemaat berhasil dihapus!');
        } catch (\Exception $e) {
            // Log::error('Error deleting Member:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
