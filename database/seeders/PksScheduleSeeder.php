<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PksSchedule; // Pastikan model PksSchedule di-import
use Faker\Generator as Faker; // Untuk menggunakan Faker
use Carbon\Carbon; // Untuk menggunakan Carbon

class PksScheduleSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = app(Faker::class);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Hapus data lama untuk menghindari duplikasi saat seeding
        PksSchedule::truncate();

        for ($i = 0; $i < 15; $i++) { // Membuat 15 jadwal PKS dummy
            $day = $this->faker->randomElement($daysOfWeek);
            $time = $this->faker->time('H:i'); // Waktu dalam format HH:MM

            PksSchedule::create([
                'activity_name' => $this->faker->randomElement([
                    'PKS Sektor ' . $this->faker->randomLetter(),
                    'Persekutuan Doa Keluarga ' . $this->faker->lastName(),
                    'Ibadah Rumah Tangga Komsel ' . $this->faker->randomNumber(1),
                ]),
                'day_of_week' => $day,
                'date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'), // <-- TAMBAHKAN INI
                'time' => $time,
                'location' => 'Rumah ' . $this->faker->name() . ' (' . $this->faker->address() . ')',
                'leader_name' => $this->faker->name(),
                'description' => $this->faker->optional(0.7)->sentence(),
                'involved_members' => $this->faker->optional(0.8)->sentence(rand(5, 15)),
                'is_active' => $this->faker->boolean(90),
            ]);
        }

        // Tambahkan contoh dari user:
        PksSchedule::create([
            'activity_name' => 'PKS Rumah Tangga Keluarga Masri',
            'day_of_week' => 'Senin',
            'date' => Carbon::now()->next(Carbon::MONDAY)->format('Y-m-d'), // <-- TAMBAHKAN TANGGAL SPESIFIK
            'time' => '19:00:00',
            'location' => 'Rumah Bapak Masri, Tanagga',
            'leader_name' => 'Diaken D.D Kaka',
            'description' => 'Persekutuan Keluarga rutin.',
            'involved_members' => 'Ibu Selfi, Bapak Ranus, dll.',
            'is_active' => true,
        ]);

        PksSchedule::create([
            'activity_name' => 'PKS Rumah Tangga Keluarga Selfi',
            'day_of_week' => 'Rabu',
            'date' => Carbon::now()->next(Carbon::WEDNESDAY)->format('Y-m-d'), // <-- TAMBAHKAN TANGGAL SPESIFIK
            'time' => '19:00:00',
            'location' => 'Rumah Ibu Selfi, Tanagga',
            'leader_name' => 'Diaken D.D Kaka',
            'description' => 'Persekutuan Keluarga rutin.',
            'involved_members' => 'Bapak Masri, Bapak Ranus, dll.',
            'is_active' => true,
        ]);
    }
}