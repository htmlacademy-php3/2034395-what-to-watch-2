<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->title(),
            'poster_image' => fake()->imageUrl(),
            'preview_image' => fake()->imageUrl(),
            'background_image' => fake()->imageUrl(),
            'background_color' => fake()->hexColor(),
            'video_link' => fake()->url(),
            'preview_video_link' => fake()->url(),
            'description' => fake()->realText(),
            'director' => fake()->name(),
            'run_time' => fake()->numberBetween(60, 200),
            'released' => fake()->numberBetween(1940, 2023),
            'imdb_id' => 'tt' . fake()->unique()->uuid(),
            'status' => 'ready',
            'is_promo' => 0,
        ];
    }
}
