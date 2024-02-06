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
            ],
            'Metal' => [
                'Heavy Metal',
                'Thrash Metal',
                'Death Metal',
                'Black Metal',
                'Doom Metal',
            ],
            'Pop' => [
                'Dance Pop',
                'Synth Pop',
                'Electropop',
                'Indie Pop',
                'Art Pop',
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
