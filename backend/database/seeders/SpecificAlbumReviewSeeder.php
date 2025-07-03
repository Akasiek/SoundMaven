<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumReview;
use Illuminate\Database\Seeder;

class SpecificAlbumReviewSeeder extends Seeder
{
    public function run(): void
    {
        $albumTitle = $this->command->askWithCompletion('Enter the album name to seed reviews for', Album::pluck('title')->toArray());
        $album = Album::where('title', $albumTitle)->first();
        if (!$album) {
            $this->command->error("Album with title '$albumTitle' not found.");
            return;
        }

        $count = (int)$this->command->ask('How many reviews would you like to create for this album?', 100);

        AlbumReview::factory($count)->create([
            'album_id' => $album->id,
        ]);
    }
}
