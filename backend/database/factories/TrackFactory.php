<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'length' => fake()->numberBetween(60, 600),
            'order' => fake()->numberBetween(1, 20),
            'album_id' => Album::factory(),
        ];
    }
}
