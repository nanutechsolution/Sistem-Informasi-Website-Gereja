<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member; // Import Model Member
use App\Models\Post;   // Import Model Post
use App\Models\Schedule; // Import Model Schedule
use App\Models\Event;   // Import Model Event
use App\Models\Income;  // Import Model Income
use App\Models\Expense; // Import Model Expense
use App\Models\Kas;
use App\Models\Notification;
use App\Models\PksSchedule;
use Carbon\Carbon;     // Import Carbon
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function index()
    {
        // Statistik Umum
        $totalMembers = Member::count();
        $totalActiveMembers = Member::where('status', 'Aktif')->count(); // Jika ada kolom status di Member
        $totalPindahMembers = Member::where('status', 'Pindah')->count(); // Jika ada kolom status di Member
        $totalDeadMembers = Member::where('status', 'Non-aktif')->count(); // Jika ada kolom status di Member

        // Statistik Konten
        $totalPublishedPosts = Post::where('is_published', true)->count();
        $totalDraftPosts = Post::where('is_published', false)->count();

        // Statistik Jadwal & Acara
        $totalUpcomingSchedules = Schedule::where('date', '>=', Carbon::today())->count();
        $totalUpcomingEvents = Event::where('start_time', '>=', Carbon::now())->where('is_published', true)->count();
        // Statistik Keuangan (Bulan Ini)
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $currentMonthIncome = Income::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');
        $currentMonthExpense = Expense::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');
        $currentMonthBalance = $currentMonthIncome - $currentMonthExpense;
        $kasUtama = Kas::where('ks_nama', 'Kas Utama')->sum('ks_saldo');
        $kasPembangunan = Kas::where('ks_nama', 'Pembangunan')->sum('ks_saldo');
        $totalPengeluaranPembangunan = Expense::join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->join('kas', 'expense_categories.ks_id', '=', 'kas.id')
            ->where('kas.ks_nama', 'Pembangunan')
            ->sum('expenses.amount');
        $totalPengeluaranUtama = Expense::join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->join('kas', 'expense_categories.ks_id', '=', 'kas.id')
            ->where('kas.ks_nama', 'Kas Utama')
            ->sum('expenses.amount');

        // Ambil notifikasi untuk user yang sedang login, yang belum dibaca, terbaru
        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->latest()
            ->take(5) // Ambil 5 notifikasi terbaru
            ->get();

        return view('dashboard', compact(
            'totalMembers',
            'totalActiveMembers',
            'totalPublishedPosts',
            'totalDraftPosts',
            'totalUpcomingSchedules',
            'totalUpcomingEvents',
            'currentMonthIncome',
            'currentMonthExpense',
            'currentMonthBalance',
            'notifications',
            'totalPindahMembers',
            'totalDeadMembers',
            'kasUtama',
            'totalPengeluaranUtama',
            'kasPembangunan',
            'totalPengeluaranPembangunan'

        ));
    }

    // Metode untuk melihat semua notifikasi
    public function allNotifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15); // Paginate semua notifikasi

        return view('admin.notifications.index', compact('notifications'));
    }

    // Metode untuk menandai notifikasi sebagai sudah dibaca
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }
}
