<?php

use App\Http\Controllers\Admin\AnnouncementController;
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
use App\Livewire\Admin\PksSchedules\PksScheduleList;
use App\Livewire\Admin\PksSchedules\PksScheduleForm;
// Rute Publik Website Gereja
Route::get('/', [HomeController::class, 'index'])->name('home'); // <-- PERBARUI INI

Route::get('/berita', [HomeController::class, 'postsIndex'])->name('public.posts.index');
Route::get('/berita/{slug}', [HomeController::class, 'postShow'])->name('public.posts.show');

Route::get('/jadwal-ibadah', [HomeController::class, 'schedulesIndex'])->name('public.schedules.index');

Route::get('/acara', [HomeController::class, 'eventsIndex'])->name('public.events.index');
Route::get('/acara/{slug}', [HomeController::class, 'eventShow'])->name('public.events.show');

Route::get('/galeri', [HomeController::class, 'galleryIndex'])->name('public.gallery.index');
Route::get('/galeri/{album}', [HomeController::class, 'galleryShow'])->name('public.gallery.show'); // Menggunakan implicit model binding untuk Album

Route::get('/tentang-kami', [HomeController::class, 'about'])->name('public.about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('public.contact');
Route::post('/kontak', [ContactController::class, 'submit'])->name('public.contact.submit'); //  UNTUK SUBMIT FORM


// Rute Otentikasi Laravel Breeze
require __DIR__ . '/auth.php';

// Rute Admin Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Profile routes (dari Breeze, biarkan saja)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin|sekretaris|bendahara|editor_konten'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin yang sebenarnya
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('announcements', AnnouncementController::class);
    // Modul Manajemen Jadwal Ibadah & Acara
    Route::resource('schedules', ScheduleController::class);
    // Modul Manajemen Berita & Artikel 
    Route::resource('news', NewsController::class);
    // Modul Manajemen Galeri Foto & Video
    // Route::resource('gallery-albums', GalleryAlbumController::class);
    // // Custom routes untuk media di dalam album
    // Route::post('gallery-albums/{album}/media', [GalleryAlbumController::class, 'uploadMedia'])->name('gallery.albums.uploadMedia');
    // Route::delete('gallery-albums/{album}/media/{media}', [GalleryAlbumController::class, 'deleteMedia'])->name('gallery.albums.deleteMedia');

    // Gunakan parameter() untuk memastikan wildcard-nya {album}
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
    // Modul Laporan Keuangan 
    // Asumsikan admin dan bendahara bisa melihat laporan
    Route::get('finances/reports', [FinanceReportController::class, 'index'])->name('finances.reports');
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // event routes resource
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);


    // Modul Manajemen Berita/Pengumuman 
    // Asumsikan admin dan sekretaris bisa mengelola berita/pengumuman
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


    // Route::get('pks-schedules', PksScheduleList::class)->name('pks-schedules.index');
    // Route::get('pks-schedules/create', PksScheduleForm::class)->name('pks-schedules.create');
    // Route::get('pks-schedules/{pksSchedule}/edit', PksScheduleForm::class)->name('pks-schedules.edit');
});

// Rute halaman publik lainnya (akan kita tambahkan nanti)
Route::get('/about', function () {
    return view('public.about');
})->name('about');
// ... rute untuk jadwal, berita, galeri, kontak