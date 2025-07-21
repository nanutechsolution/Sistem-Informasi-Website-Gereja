<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use App\Models\User; // Pastikan Model User di-import

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan ada setidaknya 1 user di database sebelum MemberFactory berjalan.
        // Jika belum ada user, ini akan menyebabkan error.
        // Asumsi AdminUserSeeder sudah berjalan lebih dulu.
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;


        return [
            'user_id' => $userId,
            'full_name' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('################'), // 16 digit angka
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'place_of_birth' => $this->faker->city(),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'province' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),

            // --- PERBAIKI BARIS INI ---
            'baptism_date' => $this->faker->optional(0.7)->passthrough(
                $this->faker->dateTimeBetween('-30 years', '-5 years')->format('Y-m-d')
            ),
            'sidi_date' => $this->faker->optional(0.5)->passthrough(
                $this->faker->dateTimeBetween('-20 years', '-2 years')->format('Y-m-d')
            ),
            // --- AKHIR PERBAIKAN ---

            'marital_status' => $this->faker->randomElement(['Belum Menikah', 'Menikah', 'Duda', 'Janda']),
            'notes' => $this->faker->optional(0.3)->sentence(),
            'status' => $this->faker->randomElement(['Aktif', 'Non-aktif', 'Pindah']),
            'join_date' => $this->faker->dateTimeBetween('-15 years', 'now')->format('Y-m-d'),
        ];
    }
}
