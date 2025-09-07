<?php

namespace Database\Seeders;

use App\Models\Kas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kas = [

            ['ks_nama' => 'Kas Utama'],
            ['ks_nama' => 'Kas Kegiatan'],
            ['ks_nama' => 'Kas Pembangunan'],

        ];

        foreach ($kas as $ks) {
            Kas::create($ks);
        }
    }
}