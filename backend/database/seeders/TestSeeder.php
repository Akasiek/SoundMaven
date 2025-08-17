<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ArtistSeeder::class, false, ['seedImages' => false]);
        $this->call(GenreSeeder::class);
        $this->call(AlbumSeeder::class, false, ['seedImages' => false]);
        $this->call(TrackSeeder::class);
    }
}
