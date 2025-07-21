<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Gaji Pegawai', 'description' => 'Gaji dan honorarium karyawan/pendeta.'],
            ['name' => 'Biaya Listrik', 'description' => 'Pembayaran tagihan listrik.'],
            ['name' => 'Biaya Air', 'description' => 'Pembayaran tagihan air.'],
            ['name' => 'Pemeliharaan Gedung', 'description' => 'Biaya perbaikan dan perawatan fasilitas.'],
            ['name' => 'Kegiatan Sosial', 'description' => 'Pengeluaran untuk program diakonia dan sosial.'],
            ['name' => 'Pengeluaran Lain-lain', 'description' => 'Pengeluaran di luar kategori utama.'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
