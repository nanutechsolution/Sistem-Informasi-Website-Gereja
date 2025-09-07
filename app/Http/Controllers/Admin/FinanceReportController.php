<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuctionPayment;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\IncomeCategory;
use App\Models\Kas;
use App\Models\PksSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $kasUtama = Kas::where('ks_nama', 'Kas Utama')->sum('ks_saldo');
        $kasPembangunan = Kas::where('ks_nama', 'Pembangunan')->sum('ks_saldo');

        $incomes = Income::whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date', 'desc')
            ->get();
        $expenses = Expense::whereBetween('transaction_date', [$startDate, $endDate])
            ->orderBy('transaction_date', 'desc')
            ->get();
        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $balance = $totalIncome - $totalExpense;
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
        $currentMonthOffering = DB::table('pks_schedule_family')
            ->join('pks_schedules', 'pks_schedule_family.pks_schedule_id', '=', 'pks_schedules.id')
            ->whereBetween('pks_schedules.created_at', [$startDate, $endDate])
            ->where('pks_schedules.is_active', 0)
            ->sum('pks_schedule_family.offering');
        $detailOfferings = DB::table('pks_schedule_family')
            ->join('pks_schedules', 'pks_schedule_family.pks_schedule_id', '=', 'pks_schedules.id')
            ->join('families', 'pks_schedule_family.family_id', '=', 'families.id') // kalau ada tabel families
            ->where('pks_schedules.is_active', 0)
            ->whereBetween('pks_schedule_family.updated_at', [$startDate, $endDate])
            ->select(
                'pks_schedule_family.offering',
                'pks_schedule_family.updated_at',
                'families.family_name'
            )
            ->orderBy('pks_schedule_family.updated_at', 'asc')
            ->get();


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
            'incomeChartLabels',
            'incomeChartData',
            'incomeChartColors',
            'expenseChartLabels',
            'expenseChartData',
            'expenseChartColors',
            'monthlyChartLabels',
            'monthlyIncomeData',
            'monthlyExpenseData',
            'currentMonthOffering',
            'detailOfferings',
            'kasUtama',
            'kasPembangunan'
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

    public function weeklyReport()
    {
        $thisWeekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $thisWeekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);
        $asmCategoryId = Income::whereHas('category', fn($q) => $q->where('name', 'Persembahan Anak Sekolah Minggu'))->pluck('income_category_id')->first();
        $asmThisWeek = $asmCategoryId
            ? Income::where('income_category_id', $asmCategoryId)
            ->whereBetween('transaction_date', [$thisWeekStart, $thisWeekEnd])
            ->get()
            : collect();
        $adultCategoryId = Income::whereHas('category', fn($q) => $q->where('name', 'Persembahan Mingguan'))->pluck('income_category_id')->first();
        $adultLastWeek = $adultCategoryId
            ? Income::where('income_category_id', $adultCategoryId)
            ->whereBetween('transaction_date', [$lastWeekStart, $lastWeekEnd])
            ->get()
            : collect();
        $pksLastWeek = PksSchedule::with('families')
            ->whereBetween('date', [$lastWeekStart, $lastWeekEnd])
            ->get();
        $auctionPaymentsLastWeek = AuctionPayment::whereBetween('payment_date', [$lastWeekStart, $lastWeekEnd])
            ->sum('amount_paid');

        $auctionPaymentsDetailLastWeek = AuctionPayment::with('transaction')
            ->whereBetween('payment_date', [$lastWeekStart, $lastWeekEnd])
            ->get();
        $otherIncomeLastWeek = Income::whereBetween('transaction_date', [$lastWeekStart, $lastWeekEnd])
            ->orderBy('transaction_date', 'desc')
            ->get();
        $expensesLastWeek = Expense::whereBetween('transaction_date', [$lastWeekStart, $lastWeekEnd])
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('admin.finances.reports.weekly-financial', compact(
            'asmThisWeek',
            'adultLastWeek',
            'pksLastWeek',
            'thisWeekStart',
            'thisWeekEnd',
            'lastWeekStart',
            'lastWeekEnd',
            'auctionPaymentsLastWeek',
            'auctionPaymentsDetailLastWeek',
            'otherIncomeLastWeek',
            'expensesLastWeek'
        ));
    }
}