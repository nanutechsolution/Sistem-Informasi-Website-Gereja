<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PksSchedule;
use App\Models\Family;

class PksScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh beberapa keluarga

        // Contoh 3 jadwal PKS
        $schedules = [
            [
                'day_of_week' => 'Minggu',
                'date' => now()->next('Sunday')->toDateString(),
                'time' => '08:00:00',
                'leader_id' => 1, // ganti dengan ID user pemimpin
                'scripture' => 'Mazmur 23'
            ],
            [
                'day_of_week' => 'Rabu',
                'date' => now()->next('Wednesday')->toDateString(),
                'time' => '19:00:00',
                'leader_id' => 2,
                'scripture' => 'Yohanes 3:16'
            ],
            [
                'day_of_week' => 'Sabtu',
                'date' => now()->next('Saturday')->toDateString(),
                'time' => '18:00:00',
                'leader_id' => 2,
                'scripture' => 'Amsal 3:5-6'
            ],
        ];

        $families = Family::all();
        if ($families->isEmpty()) {
            $this->command->info("Belum ada keluarga, seeder dibatalkan");
            return;
        }

        foreach ($schedules as $data) {
            $schedule = PksSchedule::create($data);

            foreach ($families as $family) {
                $schedule->families()->attach($family->id, [
                    'offering' => rand(50000, 200000)
                ]);
            }
        }
    }
}