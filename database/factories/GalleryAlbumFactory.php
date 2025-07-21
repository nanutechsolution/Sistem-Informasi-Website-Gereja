<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GalleryAlbum; // Pastikan Model GalleryAlbum di-import

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryAlbum>
 */
class GalleryAlbumFactory extends Factory
{
    /**
     * The name of the corresponding model.
     *
     * @var string
     */
    protected $model = GalleryAlbum::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(rand(3, 7)) . ' Gallery',
            'description' => $this->faker->optional(0.7)->paragraph(rand(1, 3)),
            'event_date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'cover_image' => $this->faker->optional(0.5)->imageUrl(640, 480, 'church event'), // Gambar cover opsional
        ];
    }
}
