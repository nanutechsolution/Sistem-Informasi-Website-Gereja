<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Family;
use App\Models\Member;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua member, kalau kosong kasih info
        $members = Member::all();

        if ($members->isEmpty()) {
            $this->command->info('Belum ada data member, seeder family dibatalkan.');
            return;
        }

        // Contoh bikin 5 keluarga
        for ($i = 1; $i <= 5; $i++) {
            // Ambil random member sebagai kepala keluarga
            $head = $members->random();

            Family::create([
                'head_member_id' => $head->id,
                'family_name' => 'Keluarga ' . $head->name,
            ]);
        }

        $this->command->info('Seeder Family selesai.');
    }
}