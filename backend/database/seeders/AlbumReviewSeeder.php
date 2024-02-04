<?php

namespace Database\Seeders;

use App\Models\AlbumReview;
use Illuminate\Database\Seeder;

class AlbumReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlbumReview::factory(100)->create();
    }
}
