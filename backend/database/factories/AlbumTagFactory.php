<?php

namespace Database\Factories;

use App\Models\AlbumTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumTagFactory extends Factory
{
    protected $model = AlbumTag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
