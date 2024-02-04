<?php

namespace Tests\Feature\Models;

use App\Models\Album;
use App\Models\Artist;
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

        $album->addReview([
            'rating' => 50,
            'body' => 'New Review. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $this->assertDatabaseHas('album_reviews', [
            'rating' => 50,
            'body' => 'New Review. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'album_id' => $album->id,
        ]);

    }

    public function test_can_edit_review()
    {
        $album = Album::factory()->create();

        $review = $album->addReview([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->updateReview($review, [
            'rating' => 100,
            'body' => 'Edited Review',
        ]);

        $this->assertDatabaseHas('album_reviews', [
            'rating' => 100,
            'body' => 'Edited Review',
            'album_id' => $album->id,
        ]);
    }

    public function test_can_delete_review()
    {
        $album = Album::factory()->create();

        $review = $album->addReview([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->deleteReview($review);

        $this->assertDatabaseMissing('album_reviews', [
            'album_id' => $album->id,
        ]);
    }

    public function test_can_get_average_rating()
    {
        $album = Album::factory()->create();

        $album->addReview([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->addReview([
            'rating' => 100,
            'body' => 'New Review',
        ]);

        $this->assertEquals(75, $album->averageRating());
    }

    public function test_can_add_genre()
    {
        $album = Album::factory()->create();

        $album->addGenre('Rock');

        $this->assertDatabaseHas('album_genres', [
            'album_id' => $album->id,
            'genre' => 'Rock',
        ]);
    }

    public function test_can_delete_genre()
    {
        $album = Album::factory()->create();

        $album->addGenre('Rock');

        $album->deleteGenre('Rock');

        $this->assertDatabaseMissing('album_genres', [
            'album_id' => $album->id,
            'genre' => 'Rock',
        ]);
    }

    public function test_can_get_genres()
    {
        $album = Album::factory()->create();

        $album->addGenre('Rock');
        $album->addGenre('Pop');

        $this->assertEquals(['Rock', 'Pop'], $album->getGenres());
    }

    public function test_can_add_track()
    {
        $album = Album::factory()->create();

        $album->addTrack([
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);

        $this->assertDatabaseHas('album_tracks', [
            'album_id' => $album->id,
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);
    }

    public function test_can_edit_track()
    {
        $album = Album::factory()->create();

        $album->addTrack([
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);

        $album->editTrack([
            'title' => 'Edited Track',
            'length' => '4:00',
            'order' => 2,
        ]);

        $this->assertDatabaseHas('album_tracks', [
            'album_id' => $album->id,
            'title' => 'Edited Track',
            'length' => '4:00',
            'order' => 2,
        ]);
    }

    public function test_can_delete_track()
    {
        $album = Album::factory()->create();

        $album->addTrack([
            'title' => 'New Track',
            'length' => '3:00',
            'order' => 1,
        ]);

        $album->deleteTrack();

        $this->assertDatabaseMissing('album_tracks', [
            'album_id' => $album->id,
        ]);
    }
}
