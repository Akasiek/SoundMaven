<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumReview;
use App\Models\User;
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

        $count = (int) $this->command->ask('How many reviews would you like to create for this album?', 100);

        foreach (range(1, $count) as $ignored) {
            auth()->login($this->getUser($album));

            AlbumReview::factory()->create([
                'album_id' => $album->id,
            ]);
        }
    }

    private function getUser($album): User
    {
        $dbHasLessThenTwentyUsers = User::count() < 20;
        if ($dbHasLessThenTwentyUsers) {
            return User::factory()->create();
        }

        $user = User::inRandomOrder()->first();

        // Check if the user already reviewed the album
        if ($album->reviews()->where('created_by', $user->id)->exists()) {
            return User::factory()->create();
        }

        return $user;
    }
}
