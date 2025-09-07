<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory; // Pastikan model ExpenseCategory di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ExpenseCategoryController extends Controller
{
    /**
     * Tampilkan daftar semua kategori pengeluaran.
     */
    public function index()
    {
        $categories = ExpenseCategory::with('kas')->latest()->paginate(10);
        return view('admin.finances.expense_categories.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk membuat kategori pengeluaran baru.
     */
    public function create()
    {
        return view('admin.finances.expense_categories.create');
    }

    /**
     * Simpan kategori pengeluaran baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:expense_categories,name',
                'description' => 'nullable|string',
            ]);

            ExpenseCategory::create($validatedData);

            return redirect()->route('admin.expense-categories.index')->with('success', 'Kategori Pengeluaran berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing ExpenseCategory:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail kategori pengeluaran (opsional).
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return view('admin.finances.expense_categories.show', compact('expenseCategory'));
    }

    /**
     * Tampilkan form untuk mengedit kategori pengeluaran.
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('admin.finances.expense_categories.edit', compact('expenseCategory'));
    }

    /**
     * Perbarui kategori pengeluaran di database.
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:expense_categories,name,' . $expenseCategory->id,
                'description' => 'nullable|string',
            ]);

            $expenseCategory->update($validatedData);

            return redirect()->route('admin.expense-categories.index')->with('success', 'Kategori Pengeluaran berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating ExpenseCategory:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus kategori pengeluaran dari database.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        try {
            // Cek apakah ada pengeluaran yang terkait dengan kategori ini
            if ($expenseCategory->expenses()->count() > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus kategori ini karena masih ada pengeluaran yang terkait.');
            }

            $expenseCategory->delete();
            return redirect()->route('admin.expense-categories.index')->with('success', 'Kategori Pengeluaran berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting ExpenseCategory:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}