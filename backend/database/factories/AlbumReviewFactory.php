<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AlbumReview>
 */
class AlbumReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 100),
            'body' => fake()->text(1024),
            'album_id' => Album::inRandomOrder()->first()?->id ?? Album::factory()->create()->id,
            'created_by' => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id,
        ];
    }
}
