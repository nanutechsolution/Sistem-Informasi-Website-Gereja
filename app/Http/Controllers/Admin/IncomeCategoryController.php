<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory; // Pastikan model IncomeCategory di-import
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class IncomeCategoryController extends Controller
{
    /**
     * Tampilkan daftar semua kategori pemasukan.
     */
    public function index()
    {
        $categories = IncomeCategory::with('kas')->latest()->paginate(10);
        return view('admin.finances.income_categories.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk membuat kategori pemasukan baru.
     */
    public function create()
    {
        $kas = Kas::all();
        return view('admin.finances.income_categories.create', compact('kas'));
    }

    /**
     * Simpan kategori pemasukan baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:income_categories,name',
                'description' => 'nullable|string',
                'ks_id' => 'required|exists:kas,id',
            ]);

            IncomeCategory::create($validatedData);

            return redirect()->route('admin.income-categories.index')->with('success', 'Kategori Pemasukan berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing IncomeCategory:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail kategori pemasukan (opsional).
     */
    public function show(IncomeCategory $incomeCategory)
    {
        return view('admin.finances.income_categories.show', compact('incomeCategory'));
    }

    /**
     * Tampilkan form untuk mengedit kategori pemasukan.
     */
    public function edit(IncomeCategory $incomeCategory)
    {
        return view('admin.finances.income_categories.edit', compact('incomeCategory'));
    }

    /**
     * Perbarui kategori pemasukan di database.
     */
    public function update(Request $request, IncomeCategory $incomeCategory)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:income_categories,name,' . $incomeCategory->id,
                'description' => 'nullable|string',
            ]);

            $incomeCategory->update($validatedData);

            return redirect()->route('admin.income-categories.index')->with('success', 'Kategori Pemasukan berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating IncomeCategory:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus kategori pemasukan dari database.
     */
    public function destroy(IncomeCategory $incomeCategory)
    {
        try {
            // Cek apakah ada pemasukan yang terkait dengan kategori ini
            if ($incomeCategory->incomes()->count() > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus kategori ini karena masih ada pemasukan yang terkait.');
            }

            $incomeCategory->delete();
            return redirect()->route('admin.income-categories.index')->with('success', 'Kategori Pemasukan berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting IncomeCategory:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}