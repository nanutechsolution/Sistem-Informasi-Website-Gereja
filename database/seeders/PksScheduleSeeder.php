<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PksSchedule;
use Faker\Generator as Faker;
use Carbon\Carbon;

class PksScheduleSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = app(Faker::class);
    }

    public function run(): void
    {
        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Hapus data lama
        PksSchedule::truncate();
        $familyId = \App\Models\Family::inRandomOrder()->first()?->id;
        $leaderId = \App\Models\User::inRandomOrder()->first()?->id;

        // Generate 15 jadwal dummy
        for ($i = 0; $i < 15; $i++) {
            PksSchedule::create([
                'day_of_week' => $this->faker->randomElement($daysOfWeek),
                'date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
                'time' => $this->faker->time('H:i:s'),
                'involved_members' => $this->faker->optional(0.8)->sentence(rand(5, 15)),
                'is_active' => $this->faker->boolean(90),
                'family_id' => $familyId, // ganti dengan ID keluarga Masri di tabel families
                'leader_id' => $leaderId, // ganti dengan ID user pemimpin
                'scripture' => $this->faker->optional()->sentence(),
            ]);
        }

        // Contoh spesifik PKS keluarga Masri
        PksSchedule::create([
            'day_of_week' => 'Senin',
            'date' => Carbon::now()->next(Carbon::MONDAY)->format('Y-m-d'),
            'time' => '19:00:00',
            'involved_members' => 'Ibu Selfi, Bapak Ranus, dll.',
            'is_active' => true,
            'family_id' => $familyId, // ganti dengan ID keluarga Masri di tabel families
            'leader_id' => $leaderId, // ganti dengan ID user pemimpin
            'scripture' => 'Mazmur 23:1-3',
        ]);

        // Contoh spesifik PKS keluarga Selfi
        PksSchedule::create([
            'day_of_week' => 'Rabu',
            'date' => Carbon::now()->next(Carbon::WEDNESDAY)->format('Y-m-d'),
            'time' => '19:00:00',
            'involved_members' => 'Bapak Masri, Bapak Ranus, dll.',
            'is_active' => true,
            'family_id' => $familyId, // ganti dengan ID keluarga Masri di tabel families
            'leader_id' => $leaderId, // ganti dengan ID user pemimpin
            'scripture' => 'Yesaya 40:31',
        ]);
    }
}