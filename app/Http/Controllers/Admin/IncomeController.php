<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income; // Pastikan model Income di-import
use App\Models\IncomeCategory; // Pastikan model IncomeCategory di-import
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login
use Illuminate\Support\Facades\Log; // Untuk debugging

class IncomeController extends Controller
{
    /**
     * Tampilkan daftar semua pemasukan.
     */
    public function index()
    {
        // Ambil semua pemasukan, urutkan berdasarkan tanggal transaksi terbaru
        $incomes = Income::with('category', 'recordedBy')->latest('transaction_date')->paginate(10);

        return view('admin.finances.incomes.index', compact('incomes'));
    }

    /**
     * Tampilkan form untuk membuat pemasukan baru.
     */
    public function create()
    {
        $categories = IncomeCategory::orderBy('name')->get();
        return view('admin.finances.incomes.create', compact('categories'));
    }

    /**
     * Simpan pemasukan baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'income_category_id' => 'required|exists:income_categories,id',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'transaction_date' => 'required|date',
                'source' => 'nullable|string|max:255',
                'proof_of_transaction' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            ]);

            // Handle proof of transaction upload
            if ($request->hasFile('proof_of_transaction')) {
                $filePath = $request->file('proof_of_transaction')->store('income_proofs', 'public');
                $validatedData['proof_of_transaction'] = $filePath;
            }

            $validatedData['recorded_by_user_id'] = Auth::id(); // Otomatis catat user yang input

            Income::create($validatedData);

            return redirect()->route('admin.incomes.index')->with('success', 'Pemasukan berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing Income:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail pemasukan (opsional).
     */
    public function show(Income $income)
    {
        return view('admin.finances.incomes.show', compact('income'));
    }

    /**
     * Tampilkan form untuk mengedit pemasukan.
     */
    public function edit(Income $income)
    {
        $categories = IncomeCategory::orderBy('name')->get();
        return view('admin.finances.incomes.edit', compact('income', 'categories'));
    }

    /**
     * Perbarui pemasukan di database.
     */
    public function update(Request $request, Income $income)
    {
        try {
            $validatedData = $request->validate([
                'income_category_id' => 'required|exists:income_categories,id',
                'amount' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'transaction_date' => 'required|date',
                'source' => 'nullable|string|max:255',
                'proof_of_transaction' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);

            // Handle proof of transaction update
            if ($request->hasFile('proof_of_transaction')) {
                if ($income->proof_of_transaction && Storage::disk('public')->exists($income->proof_of_transaction)) {
                    Storage::disk('public')->delete($income->proof_of_transaction);
                }
                $filePath = $request->file('proof_of_transaction')->store('income_proofs', 'public');
                $validatedData['proof_of_transaction'] = $filePath;
            } else {
                $validatedData['proof_of_transaction'] = $income->proof_of_transaction; // Pertahankan yang lama
            }

            $income->update($validatedData);

            return redirect()->route('admin.incomes.index')->with('success', 'Pemasukan berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating Income:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus pemasukan dari database.
     */
    public function destroy(Income $income)
    {
        try {
            // Hapus file bukti transaksi jika ada
            if ($income->proof_of_transaction && Storage::disk('public')->exists($income->proof_of_transaction)) {
                Storage::disk('public')->delete($income->proof_of_transaction);
            }
            $income->delete();
            return redirect()->route('admin.incomes.index')->with('success', 'Pemasukan berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Income:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
