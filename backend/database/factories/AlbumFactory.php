<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(1024),
            'release_date' => fake()->date(),
            'type' => fake()->randomElement(['LP', 'EP', 'Single', 'Compilation', 'Live', 'Soundtrack', 'Remix', 'Other']),
            'artist_id' => Artist::factory(),
        ];
    }
}
