<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
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
        $faker = FakerFactory::create('id_ID');
        // Pastikan ada setidaknya 1 user di database sebelum MemberFactory berjalan.
        // Jika belum ada user, ini akan menyebabkan error.
        // Asumsi AdminUserSeeder sudah berjalan lebih dulu.
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;

        return [
            'user_id' => $userId,
            'full_name' => $faker->name(),
            'nik' => $faker->unique()->numerify('################'), // 16 digit angka
            'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
            'date_of_birth' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'place_of_birth' => $faker->city(),
            'blood_type' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'address' => $faker->address(),
            'city' => $faker->city(),
            'province' => $faker->state(),
            'postal_code' => $faker->postcode(),
            'phone_number' => $faker->phoneNumber(),
            'email' => $faker->unique()->safeEmail(),
            'baptism_date' => $faker->optional(0.7)->passthrough(
                $faker->dateTimeBetween('-30 years', '-5 years')->format('Y-m-d')
            ),
            'sidi_date' => $faker->optional(0.5)->passthrough(
                $faker->dateTimeBetween('-20 years', '-2 years')->format('Y-m-d')
            ),
            'marital_status' => $faker->randomElement(['Belum Menikah', 'Menikah', 'Duda', 'Janda']),
            'notes' => $faker->optional(0.3)->sentence(),
            'status' => $faker->randomElement(['Aktif', 'Non-aktif', 'Pindah']),
            'join_date' => $faker->dateTimeBetween('-15 years', 'now')->format('Y-m-d'),
        ];
    }
}