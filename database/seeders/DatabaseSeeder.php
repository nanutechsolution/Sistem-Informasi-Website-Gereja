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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        // Transaksi Keuangan (anak) sebelum Kategori (induk)
        \App\Models\Income::truncate();
        \App\Models\Expense::truncate();
        \App\Models\IncomeCategory::truncate(); // Sekarang boleh di-truncate
        \App\Models\ExpenseCategory::truncate(); // Sekarang boleh di-truncate

        \App\Models\MinistryMember::truncate(); // Pivot table
        \App\Models\Ministry::truncate(); // Sekarang boleh di-truncate
        \App\Models\Member::truncate(); // Memerlukan user_id, tapi bisa di-truncate sebelum User jika user juga di-truncate.
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


        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,

            MemberSeeder::class,
            MinistrySeeder::class,
            IncomeCategorySeeder::class,
            ExpenseCategorySeeder::class,
            PostSeeder::class,
            EventSeeder::class,
            ScheduleSeeder::class,
            GalleryAlbumSeeder::class,

            IncomeSeeder::class,
            ExpenseSeeder::class,
            FamilySeeder::class,
            PksScheduleSeeder::class,
            ChurchSettingSeeder::class,
            // AuctionSeeder::class,
        ]);
    }
}