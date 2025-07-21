<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedule; // Pastikan Model Schedule di-import
use Carbon\Carbon; // Pastikan Carbon di-import

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 month', '+3 months'); // Tanggal dalam 1 bulan ke belakang sampai 3 bulan ke depan
        $time = $this->faker->time('H:i:s'); // Waktu random

        return [
            'title' => $this->faker->randomElement([
                'Ibadah Doa Malam',
                'Persekutuan Remaja',
                'Latihan Paduan Suara',
                'Kelas Katekisasi',
                'Ibadah Keluarga Sektor ' . $this->faker->randomLetter(),
                'Rapat Majelis Jemaat'
            ]),
            'description' => $this->faker->optional(0.7)->sentence(rand(5, 10)), // Deskripsi opsional
            'date' => $date->format('Y-m-d'),
            'time' => $time,
            'location' => $this->faker->randomElement([
                'Gereja Induk',
                'Ruang Serbaguna',
                'Sekretariat',
                'Rumah Jemaat ' . $this->faker->lastName()
            ]),
        ];
    }
}
