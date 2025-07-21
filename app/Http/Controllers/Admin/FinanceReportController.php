<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class FinanceReportController extends Controller
{
    /**
     * Tampilkan halaman laporan keuangan.
     */
    public function index(Request $request)
    {
        // Ambil rentang tanggal dari request, default ke bulan ini
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();

        // Ambil data pemasukan dan pengeluaran dalam rentang tanggal
        $incomes = Income::whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $expenses = Expense::whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Hitung total pemasukan dan pengeluaran
        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $balance = $totalIncome - $totalExpense;


        // Data untuk ringkasan per kategori (tetap sama)
        $incomeCategoriesSummary = Income::selectRaw('income_category_id, SUM(amount) as total_amount')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('income_category_id')
            ->with('category')
            ->get();

        $expenseCategoriesSummary = Expense::selectRaw('expense_category_id, SUM(amount) as total_amount')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('expense_category_id')
            ->with('category')
            ->get();

        // --- Data untuk Chart.js ---

        // Grafik Pemasukan per Kategori (Pie Chart)
        $incomeChartLabels = $incomeCategoriesSummary->map(function ($item) {
            return $item->category->name ?? 'Tidak Diketahui';
        })->all();
        $incomeChartData = $incomeCategoriesSummary->map(function ($item) {
            return $item->total_amount;
        })->all();
        $incomeChartColors = $this->generateRandomColors(count($incomeChartLabels));

        // Grafik Pengeluaran per Kategori (Pie Chart)
        $expenseChartLabels = $expenseCategoriesSummary->map(function ($item) {
            return $item->category->name ?? 'Tidak Diketahui';
        })->all();
        $expenseChartData = $expenseCategoriesSummary->map(function ($item) {
            return $item->total_amount;
        })->all();
        $expenseChartColors = $this->generateRandomColors(count($expenseChartLabels));

        // Grafik Pemasukan vs Pengeluaran Bulanan (Line Chart/Bar Chart)
        $monthlyData = $this->getMonthlyFinancialData($startDate, $endDate);
        $monthlyChartLabels = $monthlyData->keys()->all();
        $monthlyIncomeData = $monthlyData->map(fn($data) => $data['income'])->values()->all();
        $monthlyExpenseData = $monthlyData->map(fn($data) => $data['expense'])->values()->all();



        return view('admin.finances.reports.index', compact(
            'incomes',
            'expenses',
            'totalIncome',
            'totalExpense',
            'balance',
            'startDate',
            'endDate',
            'incomeCategoriesSummary',
            'expenseCategoriesSummary',
            'incomeChartLabels',    // Data untuk Chart.js
            'incomeChartData',
            'incomeChartColors',
            'expenseChartLabels',
            'expenseChartData',
            'expenseChartColors',
            'monthlyChartLabels',   // Data untuk grafik bulanan
            'monthlyIncomeData',
            'monthlyExpenseData'
        ));
    }

    /**
     * Helper function untuk menghasilkan warna acak.
     */
    private function generateRandomColors($count)
    {
        $colors = [];
        for ($i = 0; $i < $count; $i++) {
            $r = mt_rand(0, 255);
            $g = mt_rand(0, 255);
            $b = mt_rand(0, 255);
            $colors[] = "rgba($r, $g, $b, 0.7)"; // Dengan sedikit opacity
        }
        return $colors;
    }

    /**
     * Helper function untuk mengambil data keuangan bulanan.
     * Ini bisa diperluas untuk ringkasan per hari/minggu jika dibutuhkan.
     */
    private function getMonthlyFinancialData(Carbon $startDate, Carbon $endDate)
    {
        $data = collect();
        $currentDate = $startDate->copy()->startOfMonth();

        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $monthName = $currentDate->format('M Y');

            $monthlyIncome = Income::whereYear('transaction_date', $currentDate->year)
                ->whereMonth('transaction_date', $currentDate->month)
                ->sum('amount');

            $monthlyExpense = Expense::whereYear('transaction_date', $currentDate->year)
                ->whereMonth('transaction_date', $currentDate->month)
                ->sum('amount');

            $data->put($monthName, [
                'income' => $monthlyIncome,
                'expense' => $monthlyExpense
            ]);

            $currentDate->addMonth();
        }

        return $data;
    }
}
