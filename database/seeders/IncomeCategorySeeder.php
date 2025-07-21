<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Persembahan Mingguan', 'description' => 'Pemasukan dari ibadah Minggu rutin.'],
            ['name' => 'Perpuluhan', 'description' => 'Persepuluhan jemaat.'],
            ['name' => 'Donasi Khusus', 'description' => 'Donasi untuk proyek atau program spesifik.'],
            ['name' => 'Sewa Aset', 'description' => 'Pemasukan dari penyewaan fasilitas gereja.'],
            ['name' => 'Pemasukan Lain-lain', 'description' => 'Sumber pemasukan di luar kategori utama.'],
        ];

        foreach ($categories as $category) {
            IncomeCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
