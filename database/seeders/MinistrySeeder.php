<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ministry;
use App\Models\Member; // Untuk mengaitkan anggota

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ministries = [
            ['name' => 'Komisi Pelayanan Anak', 'description' => 'Bertanggung jawab atas pembinaan rohani anak-anak.'],
            ['name' => 'Komisi Pelayanan Remaja', 'description' => 'Membina dan mengarahkan remaja dalam iman.'],
            ['name' => 'Komisi Pelayanan Pemuda', 'description' => 'Mengembangkan potensi pemuda gereja.'],
            ['name' => 'Komisi Diakonia', 'description' => 'Pelayanan sosial dan kepedulian kepada sesama.'],
            ['name' => 'Komisi Musik & Liturgi', 'description' => 'Mengkoordinir pujian dan ibadah.'],
        ];

        foreach ($ministries as $data) {
            Ministry::firstOrCreate(['name' => $data['name']], $data);
        }

        // Kaitkan beberapa anggota ke pelayanan
        $allMembers = Member::all();
        $allMinistries = Ministry::all();

        if ($allMembers->isNotEmpty() && $allMinistries->isNotEmpty()) {
            foreach ($allMinistries as $ministry) {
                // Ambil 3-5 anggota secara acak untuk setiap pelayanan
                $randomMembers = $allMembers->random(min(rand(1, 5), $allMembers->count()));
                foreach ($randomMembers as $member) {
                    // Cek apakah relasi sudah ada
                    if (!$ministry->members()->where('member_id', $member->id)->exists()) {
                        $ministry->members()->attach($member->id, [
                            'role' => (rand(0, 1) == 1) ? 'Koordinator' : 'Anggota',
                            'joined_date' => now()->subMonths(rand(1, 60)),
                        ]);
                    }
                }
            }
        }
    }
}
