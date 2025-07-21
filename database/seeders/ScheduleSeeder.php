<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus schedules lama untuk menghindari duplikasi jadwal rutin
        Schedule::truncate();

        $today = Carbon::today();

        // Jadwal Ibadah Minggu (berulang, tapi di seeder kita buat beberapa saja)
        for ($i = 0; $i < 4; $i++) { // Buat jadwal untuk 4 minggu ke depan
            $date = $today->copy()->addWeeks($i)->next(Carbon::SUNDAY);
            Schedule::create([
                'title' => 'Ibadah Minggu Raya',
                'description' => 'Ibadah minggu rutin seluruh jemaat.',
                'date' => $date,
                'time' => '09:00:00',
                'location' => 'Gereja Induk',
            ]);
            Schedule::create([
                'title' => 'Ibadah Minggu Sore',
                'description' => 'Ibadah minggu rutin seluruh jemaat (sesi kedua).',
                'date' => $date,
                'time' => '17:00:00',
                'location' => 'Gereja Induk',
            ]);
        }

        // Jadwal Persekutuan Doa (setiap Rabu)
        for ($i = 0; $i < 4; $i++) {
            $date = $today->copy()->addWeeks($i)->next(Carbon::WEDNESDAY);
            Schedule::create([
                'title' => 'Persekutuan Doa Gabungan',
                'description' => 'Persekutuan doa bersama setiap Rabu malam.',
                'date' => $date,
                'time' => '19:00:00',
                'location' => 'Ruang Doa',
            ]);
        }

        // Jadwal PA Sektor (setiap Jumat)
        for ($i = 0; $i < 4; $i++) {
            $date = $today->copy()->addWeeks($i)->next(Carbon::FRIDAY);
            Schedule::create([
                'title' => 'Persekutuan Anggota Sektor B',
                'description' => 'Pendalaman Alkitab per sektor.',
                'date' => $date,
                'time' => '19:30:00',
                'location' => 'Rumah Jemaat Sektor B',
            ]);
        }

        Schedule::factory(5)->create(); // Tambah beberapa jadwal dummy lainnya
    }
}
