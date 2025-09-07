<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PksSchedule;
use App\Models\Family;
use App\Models\Member;

class PksScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $families = Family::all();
        $members  = Member::pluck('full_name')->toArray();

        if ($families->isEmpty() || empty($members)) {
            $this->command->info("Belum ada keluarga atau member, seeder dibatalkan.");
            return;
        }

        $leaders = [1, 2, 3, 4, 5]; // ID user pemimpin (ubah sesuai data User Anda)
        $faker   = fake('id_ID');

        for ($i = 1; $i <= 20; $i++) {
            // Pilih hari (acak antara Rabu atau Jumat)
            $day = $faker->randomElement(['Rabu', 'Jumat']);
            $dayEn = $day === 'Rabu' ? 'Wednesday' : 'Friday';

            // Tanggal otomatis maju sesuai minggu + hari
            $date = now()->addWeeks($i)->next($dayEn)->toDateString();

            // Pilih 3–5 anggota acak
            $involved = $faker->randomElements($members, rand(3, 5));

            $schedule = PksSchedule::create([
                'day_of_week'      => $day,
                'date'             => $date,
                'time'             => $day === 'Rabu' ? '19:00:00' : '18:00:00',
                'leader_id'        => $faker->randomElement($leaders),
                'scripture'        => $faker->randomElement([
                    'Mazmur 23',
                    'Yohanes 3:16',
                    'Amsal 3:5-6',
                    'Filipi 4:13',
                    'Yeremia 29:11',
                    'Roma 8:28'
                ]),
                'involved_members' => json_encode($involved, JSON_UNESCAPED_UNICODE),
            ]);

            // Pilih keluarga acak (boleh terulang)
            $family = $families->random();
            $schedule->families()->attach($family->id, [
                // 'offering' => rand(50000, 200000),
            ]);
        }

        $this->command->info("Seeder PKS selesai: 20 jadwal (hanya Rabu & Jumat) dengan anggota terlibat.");
    }
}