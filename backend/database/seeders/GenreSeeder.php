<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Rock' => [
                'Progressive Rock',
                'Post-Rock',
                'Art Rock',
                'Experimental Rock',
                'Psychedelic Rock',
                'Alternative Rock',
                'Indie Rock',
                'Hard Rock',
                'Garage Rock',
                'Garage Rock Revival',
                'Blues Rock',
                'Folk Rock',
                'Glam Rock',
                'Rock Opera',
            ],
            'Metal' => [
                'Heavy Metal',
                'Thrash Metal',
                'Death Metal',
                'Black Metal',
                'Doom Metal',
                'Progressive Metal',
                'Power Metal',
                'Groove Metal',
            ],
            'Pop' => [
                'Dance Pop',
                'Synth-pop',
                'Electropop',
                'Indie Pop',
                'Art Pop',
            ],
            'Ambient' => [
                'Drone',
            ],
            'Synthwave' => [
                'Darkwave',
            ],
        ];

        foreach ($genres as $genre => $subgenres) {
            $parent = Genre::factory()->create(['name' => $genre, 'parent_id' => null]);
            foreach ($subgenres as $subgenre) {
                Genre::factory()->create(['name' => $subgenre, 'parent_id' => $parent->id]);
            }
        }

    }
}
