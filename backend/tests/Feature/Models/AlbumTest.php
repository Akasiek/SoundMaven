<?php

namespace Tests\Feature\Models;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_be_created()
    {
        $album = Album::factory()->create();

        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
        ]);
    }

    public function test_can_be_updated()
    {
        $album = Album::factory()->create();
        $newArtist = Artist::factory()->create();

        $album->update([
            'title' => 'New Title',
            'description' => 'New Description',
            'artist_id' => $newArtist->id,
        ]);

        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
            'title' => 'New Title',
            'description' => 'New Description',
            'artist_id' => $newArtist->id,
        ]);
    }

    public function test_can_be_deleted()
    {
        $album = Album::factory()->create();

        $album->delete();

        $this->assertDatabaseMissing('albums', [
            'id' => $album->id,
        ]);
    }

    public function test_can_add_review()
    {
        $album = Album::factory()->create();

        $album->reviews()->create([
            'rating' => 50,
            'body' => 'New Review. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $this->assertDatabaseHas('album_reviews', [
            'rating' => 50,
            'body' => 'New Review. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'album_id' => $album->id,
        ]);

    }

    public function test_can_delete_review()
    {
        $album = Album::factory()->create();

        $review = $album->reviews()->create([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->reviews()->delete($review->id);

        $this->assertDatabaseMissing('album_reviews', [
            'album_id' => $album->id,
        ]);
    }

    public function test_can_get_average_rating()
    {
        $album = Album::factory()->create();

        $album->reviews()->create([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->reviews()->create([
            'rating' => 100,
            'body' => 'New Review',
        ]);

        $this->assertEquals(75, $album->averageRating());

        $album->reviews()->where(['rating' => 100])->delete();

        $this->assertEquals(50, $album->averageRating());
    }

    public function test_can_attach_genre()
    {
        $album = Album::factory()->create();
        $genre = Genre::factory()->create();

        $album->genres()->attach($genre->id);

        $this->assertDatabaseHas('album_genre', [
            'album_id' => $album->id,
            'genre_id' => $genre->id,
        ]);
    }

    public function test_can_detach_genre()
    {
        $album = Album::factory()->create();
        $genre = Genre::factory()->create();

        $album->genres()->attach($genre->id);
        $album->genres()->detach($genre->id);

        $this->assertDatabaseMissing('album_genre', [
            'album_id' => $album->id,
            'genre_id' => $genre->id,
        ]);
    }

    public function test_can_get_genres_count()
    {
        $album = Album::factory()->create();

        for ($i = 0; $i < 6; $i++) {
            $genre = Genre::factory()->create();
            $album->genres()->attach($genre->id);
        }

        $this->assertEquals(6, $album->genres()->count());
    }


    public function test_can_add_track()
    {
        $album = Album::factory()->create();

        $album->tracks()->create([
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);

        $this->assertDatabaseHas('tracks', [
            'album_id' => $album->id,
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);
    }

    public function test_can_update_track()
    {
        $album = Album::factory()->create();
        $track = $album->tracks()->create([
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);

        $album->tracks()->update($track->id, [
            'title' => 'Updated Track',
            'length' => '4:00',
            'order' => 2,
        ]);

        $this->assertDatabaseHas('tracks', [
            'album_id' => $album->id,
            'title' => 'Updated Track',
            'length' => '4:00',
            'order' => 2,
        ]);

    }

    public function test_can_delete_track()
    {
        $album = Album::factory()->create();
        $track = $album->tracks()->create([
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);

        $album->tracks()->delete($track->id);

        $this->assertDatabaseMissing('tracks', [
            'album_id' => $album->id,
        ]);
    }
}
