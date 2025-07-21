<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post; // Pastikan Model Post di-import
use App\Models\User; // Pastikan Model User di-import
use Illuminate\Support\Str; // Untuk slug

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

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
        $isPublished = $this->faker->boolean(80); // 80% kemungkinan dipublikasikan

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(rand(3, 8), true), // 3-8 paragraf
            'image' => $this->faker->optional(0.7)->imageUrl(640, 480, 'church'), // 70% kemungkinan punya gambar
            'user_id' => $userId,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
        ];
    }
}
