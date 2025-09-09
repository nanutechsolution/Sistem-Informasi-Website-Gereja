<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuctionItemController;
use App\Http\Controllers\Admin\AuctionTransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\FinanceReportController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\IncomeCategoryController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MinistryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PksScheduleController;
use App\Http\Controllers\Admin\SettingController;
use App\Models\Announcement;

Route::get('/', [HomeController::class, 'index'])->name('home'); // <-- PERBARUI INI

Route::get('/berita', [HomeController::class, 'postsIndex'])->name('public.posts.index');
Route::get('/berita/{slug}', [HomeController::class, 'postShow'])->name('public.posts.show');

Route::get('/jadwal-ibadah', [HomeController::class, 'schedulesIndex'])->name('public.schedules.index');

Route::get('/acara', [HomeController::class, 'eventsIndex'])->name('public.events.index');
Route::get('/acara/{slug}', [HomeController::class, 'eventShow'])->name('public.events.show');

Route::get('/galeri', [HomeController::class, 'galleryIndex'])->name('public.gallery.index');
Route::get('/galeri/{album}', [HomeController::class, 'galleryShow'])->name('public.gallery.show');

Route::get('/tentang-kami', [HomeController::class, 'about'])->name('public.about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('public.contact');
Route::post('/kontak', [ContactController::class, 'submit'])->name('public.contact.submit');

Route::get('/pks-calendar', [HomeController::class, 'publicCalendar'])->name('public.pks_calendar');
Route::get('/pks-calendar/data', [HomeController::class, 'calendarData'])->name('public.pks_calendar.data');
Route::get('/announcements/latest', function () {
    return Announcement::latest('published_at')->first();
});
// Rute Otentikasi Laravel Breeze
require __DIR__ . '/auth.php';

// Rute Admin Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin|sekretarais|bendahara|editor_konten|majelis'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin yang sebenarnya
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('announcements', AnnouncementController::class);
    // Modul Manajemen Jadwal Ibadah & Acara
    Route::resource('schedules', ScheduleController::class);
    // Modul Manajemen Berita & Artikel 
    Route::resource('news', NewsController::class);
    Route::resource('gallery-albums', GalleryAlbumController::class)->parameters([
        'gallery-albums' => 'album' // Ini MENGGANTI default {gallery_album} menjadi {album}
    ]);

    // Custom routes untuk media di dalam album. Sekarang juga menggunakan {album}
    Route::post('gallery-albums/{album}/media', [GalleryAlbumController::class, 'uploadMedia'])->name('gallery.albums.uploadMedia');
    Route::delete('gallery-albums/{album}/media/{media}', [GalleryAlbumController::class, 'deleteMedia'])->name('gallery.albums.deleteMedia'); // <-- PASTIKAN BARIS INI ADA DAN TEPAT SEPERTI INI


    // // Modul Manajemen Anggota Jemaat
    Route::resource('members', MemberController::class);
    // Modul Manajemen Pelayanan & Komisi Gereja 
    Route::resource('ministries', MinistryController::class);
    Route::post('ministries/{ministry}/members', [MinistryController::class, 'addMember'])->name('ministries.addMember');
    Route::delete('ministries/{ministry}/members/{member}', [MinistryController::class, 'removeMember'])->name('ministries.removeMember');
    Route::get('ministries/{ministry}/members/{member}/edit-role', [MinistryController::class, 'editMemberRole'])->name('ministries.editMemberRole');
    Route::put('ministries/{ministry}/members/{member}/update-role', [MinistryController::class, 'updateMemberRole'])->name('ministries.updateMemberRole');
    // Modul Manajemen Keuangan 
    Route::resource('incomes', IncomeController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('income-categories', IncomeCategoryController::class); // Akan dibuat nanti
    Route::resource('expense-categories', ExpenseCategoryController::class); // Akan dibuat nanti
    Route::get('finances/reports', [FinanceReportController::class, 'index'])->name('finances.reports');
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
    // event routes resource
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);


    Route::resource('posts', PostController::class);
    // Modul Manajemen Keluarga Jemaat 
    Route::resource('families', FamilyController::class)->parameters([
        'families' => 'family' // Pastikan parameter wildcard-nya {family}
    ]);
    Route::post('families/{family}/members', [FamilyController::class, 'addMemberToFamily'])->name('families.addMemberToFamily');
    Route::delete('families/{family}/members/{member}', [FamilyController::class, 'removeMemberFromFamily'])->name('families.removeMemberFromFamily');
    Route::get('families/{family}/members/{member}/edit-relationship', [FamilyController::class, 'editMemberRelationship'])->name('families.editMemberRelationship');
    Route::put('families/{family}/members/{member}/update-relationship', [FamilyController::class, 'updateMemberRelationship'])->name('families.updateMemberRelationship');
    // Modul Notifikasi 
    Route::get('notifications', [DashboardController::class, 'allNotifications'])->name('notifications.index');
    Route::post('notifications/{notification}/mark-as-read', [DashboardController::class, 'markAsRead'])->name('notifications.markAsRead');

    Route::get('pks_schedules/calendar', [PksScheduleController::class, 'calendar'])
        ->where('any', '^(?!calendar).*$')
        ->name('pks_schedules.calendar');
    Route::get('pks_schedules/calendar/data', [PksScheduleController::class, 'calendarData'])
        ->name('pks_schedules.calendar.data');
    Route::resource('pks_schedules', PksScheduleController::class);

    Route::get('pks_schedules/{schedule}/families', [PksScheduleController::class, 'getFamilies']);
    Route::post('pks_schedules/{schedule}/update-offering', [PksScheduleController::class, 'updateOffering']);

    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    // Rute untuk Manajemen Barang Lelang
    Route::resource('auction_items', AuctionItemController::class);
    // Rute untuk Pencatatan dan Laporan Transaksi
    Route::get('auction-transactions', [AuctionTransactionController::class, 'index'])->name('auction-transactions.index');
    Route::post('auction-transactions', [AuctionTransactionController::class, 'store'])->name('auction-transactions.store');
    Route::post('auction-transactions/{transaction}/payments', [AuctionTransactionController::class, 'recordPayment'])->name('auction-transactions.recordPayment');
    Route::get('auction-transactions/report', [AuctionTransactionController::class, 'getReport'])->name('auction-transactions.report');
    Route::get('auction-transactions/{transaction}/history', [AuctionTransactionController::class, 'showPaymentHistory']);
    // Route untuk Laporan Keuangan Mingguan
    Route::get('financial-report', [FinanceReportController::class, 'weeklyReport'])->name('financial-report');
});
// Rute halaman publik lainnya (akan kita tambahkan nanti)
Route::get('/about', function () {
    return view('public.about');
})->name('about');
