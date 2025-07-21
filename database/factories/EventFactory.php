<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event; // Pastikan Model Event di-import
use App\Models\User; // Pastikan Model User di-import
use Illuminate\Support\Str; // Untuk slug

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan ada setidaknya 1 user di database
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;

        $title = $this->faker->sentence(rand(5, 10)); // Judul random
        $startTime = $this->faker->dateTimeBetween('now', '+1 year');
        //  Call to undefined method DateTime::addHours()
        $endTime = (clone $startTime)->add(new \DateInterval('PT' . rand(1, 4) . 'H')); // Tambah 1-4 jam dari start time
        // $endTime = (clone $startTime)->addHours(rand(1, 4)); // Tambah 1-4 jam dari start time
        $isPublished = $this->faker->boolean(80); // 80% kemungkinan dipublikasikan

        return [
            'title' => $title,
            'slug' => Str::slug($title), // Slug otomatis
            'description' => $this->faker->paragraph(rand(2, 5)), // Deskripsi 2-5 paragraf
            'location' => $this->faker->address(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'organizer' => $this->faker->company(),
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'cancelled']),
            'is_published' => $isPublished,
            'image' => $this->faker->optional(0.5)->imageUrl(640, 480, 'event'), // 50% kemungkinan punya gambar
            'user_id' => $userId,
        ];
    }
}
