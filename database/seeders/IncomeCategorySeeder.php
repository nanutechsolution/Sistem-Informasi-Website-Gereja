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
            ['name' => 'Persembahan Mingguan', 'description' => 'Pemasukan dari ibadah Minggu rutin.', 'ks_id' => 1],
            ['name' => 'Perpuluhan', 'description' => 'Persepuluhan jemaat.', 'ks_id' => 1],
            ['name' => 'Donasi Khusus', 'description' => 'Donasi untuk proyek atau program spesifik.', 'ks_id' => 3],
        ];

        foreach ($categories as $category) {
            IncomeCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}