<?php

namespace Database\Seeders;

use App\Models\PksSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini untuk DB Facade

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Pembersihan Data Lama (Opsional, sangat disarankan untuk dev) ---
        // Hapus semua folder di public/storage
        $foldersToClear = [
            'news_images',
            'event_images',
            'gallery_covers',
            'gallery_media',
            'income_proofs',
            'expense_proofs',
            'post_images',
        ];

        foreach ($foldersToClear as $folder) {
            if (Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->deleteDirectory($folder);
            }
        }

        // Nonaktifkan Foreign Key Checks sementara untuk memungkinkan TRUNCATE pada tabel yang direferensikan
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Urutan TRUNCATE HARUS: tabel anak (yang memiliki foreign key) duluan
        // baru tabel induk (yang dirujuk oleh foreign key).

        // Transaksi Keuangan (anak) sebelum Kategori (induk)
        \App\Models\Income::truncate();
        \App\Models\Expense::truncate();
        \App\Models\IncomeCategory::truncate(); // Sekarang boleh di-truncate
        \App\Models\ExpenseCategory::truncate(); // Sekarang boleh di-truncate

        // Anggota Pelayanan (pivot) sebelum Anggota (induk) atau Pelayanan (induk)
        \App\Models\MinistryMember::truncate(); // Pivot table
        \App\Models\Ministry::truncate(); // Sekarang boleh di-truncate
        \App\Models\Member::truncate(); // Memerlukan user_id, tapi bisa di-truncate sebelum User jika user juga di-truncate.
        // Atau, jika user tidak di-truncate, cukup pastikan members_user_id foreign key nullable.

        // Media (anak) sebelum GalleryAlbum (induk)
        \App\Models\Media::truncate();
        \App\Models\GalleryAlbum::truncate(); // Sekarang boleh di-truncate

        // Post (memiliki user_id)
        \App\Models\Post::truncate();

        // Event (memiliki user_id)
        \App\Models\Event::truncate();

        // Schedule (biasanya tidak punya FK ke user)
        \App\Models\Schedule::truncate();

        // Aktifkan kembali Foreign Key Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // --- Panggil Seeder ---
        $this->call([
            // User & Role Seeder (Pastikan ini yang pertama untuk admin user)
            RoleSeeder::class,
            AdminUserSeeder::class, // Ini akan membuat user admin@gereja.com

            // Master Data (Tanpa relasi kompleks ke yang lain, atau relasi ke User saja)
            MemberSeeder::class, // Membutuhkan User
            MinistrySeeder::class, // Membutuhkan Member
            IncomeCategorySeeder::class,
            ExpenseCategorySeeder::class,

            // Konten (Membutuhkan User, mungkin juga Category)
            PostSeeder::class, // Membutuhkan User
            EventSeeder::class, // Membutuhkan User
            ScheduleSeeder::class,
            GalleryAlbumSeeder::class, // Membuat album dan media di dalamnya

            // Transaksi (Membutuhkan User, Categories)
            IncomeSeeder::class, // Membutuhkan User, IncomeCategory
            ExpenseSeeder::class, // Membutuhkan User, ExpenseCategory
            FamilySeeder::class,
            PksScheduleSeeder::class, // Membutuhkan User, ExpenseCategory
        ]);
    }
}
