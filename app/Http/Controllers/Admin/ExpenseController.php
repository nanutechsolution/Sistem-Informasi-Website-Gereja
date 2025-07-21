<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense; // Pastikan model Expense di-import
use App\Models\ExpenseCategory; // Pastikan model ExpenseCategory di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login
use Illuminate\Support\Facades\Log; // Untuk debugging

class ExpenseController extends Controller
{
    /**
     * Tampilkan daftar semua pengeluaran.
     */
    public function index()
    {
        // Ambil semua pengeluaran, urutkan berdasarkan tanggal transaksi terbaru
        $expenses = Expense::with('category', 'recordedBy')->latest('transaction_date')->paginate(10);

        return view('admin.finances.expenses.index', compact('expenses'));
    }

    /**
     * Tampilkan form untuk membuat pengeluaran baru.
     */
    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.finances.expenses.create', compact('categories'));
    }

    /**
     * Simpan pengeluaran baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'expense_category_id' => 'required|exists:expense_categories,id',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'transaction_date' => 'required|date',
                'recipient' => 'nullable|string|max:255',
                'proof_of_transaction' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            ]);

            // Handle proof of transaction upload
            if ($request->hasFile('proof_of_transaction')) {
                $filePath = $request->file('proof_of_transaction')->store('expense_proofs', 'public');
                $validatedData['proof_of_transaction'] = $filePath;
            }

            $validatedData['recorded_by_user_id'] = Auth::id(); // Otomatis catat user yang input

            Expense::create($validatedData);

            return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing Expense:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail pengeluaran (opsional).
     */
    public function show(Expense $expense)
    {
        return view('admin.finances.expenses.show', compact('expense'));
    }

    /**
     * Tampilkan form untuk mengedit pengeluaran.
     */
    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('admin.finances.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Perbarui pengeluaran di database.
     */
    public function update(Request $request, Expense $expense)
    {
        try {
            $validatedData = $request->validate([
                'expense_category_id' => 'required|exists:expense_categories,id',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'transaction_date' => 'required|date',
                'recipient' => 'nullable|string|max:255',
                'proof_of_transaction' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);

            // Handle proof of transaction update
            if ($request->hasFile('proof_of_transaction')) {
                if ($expense->proof_of_transaction && Storage::disk('public')->exists($expense->proof_of_transaction)) {
                    Storage::disk('public')->delete($expense->proof_of_transaction);
                }
                $filePath = $request->file('proof_of_transaction')->store('expense_proofs', 'public');
                $validatedData['proof_of_transaction'] = $filePath;
            } else {
                $validatedData['proof_of_transaction'] = $expense->proof_of_transaction; // Pertahankan yang lama
            }

            $expense->update($validatedData);

            return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating Expense:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus pengeluaran dari database.
     */
    public function destroy(Expense $expense)
    {
        try {
            // Hapus file bukti transaksi jika ada
            if ($expense->proof_of_transaction && Storage::disk('public')->exists($expense->proof_of_transaction)) {
                Storage::disk('public')->delete($expense->proof_of_transaction);
            }
            $expense->delete();
            return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Expense:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
