<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Family;
use App\Models\Member;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        // Buat 10 keluarga Indonesia
        for ($i = 1; $i <= 10; $i++) {
            // Ayah
            $father = Member::factory()->create([
                'gender' => 'Laki-laki',
                'marital_status' => 'Menikah',
            ]);

            // Ibu
            $mother = Member::factory()->create([
                'gender' => 'Perempuan',
                'marital_status' => 'Menikah',
            ]);

            // Bikin Family
            $family = Family::create([
                'head_member_id' => $father->id,
                'family_name' => 'Keluarga ' . $father->full_name,
            ]);

            // Tambahkan ayah & ibu ke dalam keluarga
            $family->members()->attach([$father->id, $mother->id]);

            // Tambahkan anak-anak (1–3 orang)
            $childrenCount = rand(1, 3);
            for ($j = 1; $j <= $childrenCount; $j++) {
                $child = Member::factory()->create([
                    'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
                    'marital_status' => 'Belum Menikah',
                    'date_of_birth' => fake()->dateTimeBetween('-20 years', '-1 years')->format('Y-m-d'),
                ]);

                $family->members()->attach($child->id);
            }
        }

        $this->command->info('✅ 10 keluarga Indonesia berhasil dibuat dengan ayah, ibu, dan anak-anak.');
    }
}