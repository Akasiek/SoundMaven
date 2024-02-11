<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumControllerTest extends ControllerTestCase
{
    use RefreshDatabase;

    public function test_get_albums()
    {
        Album::factory(3)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/albums');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_get_album()
    {
        $album = Album::create([
            'name' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
        ]);

        $response = $this->get("/albums/{$album->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'name' => 'Album 1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
            ]
        ]);
    }

    public function test_store_album()
    {
        $response = $this->post('/albums', [
            'name' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Album 1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
            ]
        ]);
    }

    public function test_update_album()
    {
        $album = Album::create([
            'name' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
        ]);

        $response = $this->put("/albums/{$album->id}", [
            'name' => 'Album 2',
            'description' => 'Description 2',
            'release_date' => '2021-01-02',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'name' => 'Album 2',
                'description' => 'Description 2',
                'release_date' => '2021-01-02',
            ]
        ]);
    }

    public function test_delete_album()
    {
        $album = Album::create([
            'name' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
        ]);

        $response = $this->delete("/albums/{$album->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }

    public function test_get_album_tracks()
    {
        $album = Album::factory()->create();
        $album->tracks()->createMany([
            ['title' => 'Track 1', 'duration' => 180, 'order' => 1],
            ['title' => 'Track 2', 'duration' => 240, 'order' => 2],
            ['title' => 'Track 3', 'duration' => 300, 'order' => 3],
        ]);

        $response = $this->get("/albums/{$album->id}/tracks");

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_store_album_track()
    {
        $album = Album::factory()->create();

        $response = $this->post("/albums/{$album->id}/tracks", [
            'title' => 'Track 1',
            'duration' => 180,
            'order' => 1,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Track 1',
                'duration' => 180,
                'order' => 1,
            ]
        ]);
    }

    public function test_dont_store_album_track_with_duplicate_order()
    {
        $album = Album::factory()->create();
        $album->tracks()->create([
            'title' => 'Track 1',
            'duration' => 180,
            'order' => 1,
        ]);

        $response = $this->post("/albums/{$album->id}/tracks", [
            'title' => 'Track 2',
            'duration' => 220,
            'order' => 1,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('Track with the same order already exists');
    }

    public function test_update_album_track()
    {
        $album = Album::factory()->create();
        $track = $album->tracks()->create([
            'title' => 'Track 1',
            'duration' => 180,
            'order' => 1,
        ]);

        $response = $this->put("/albums/{$album->id}/tracks/{$track->id}", [
            'title' => 'Track 2',
            'duration' => 220,
            'order' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $track->id,
                'title' => 'Track 2',
                'duration' => 220,
                'order' => 2,
            ]
        ]);
    }

    public function test_delete_album_track()
    {
        $album = Album::factory()->create();
        $track = $album->tracks()->create([
            'title' => 'Track 1',
            'duration' => 180,
            'order' => 1,
        ]);

        $response = $this->delete("/albums/{$album->id}/tracks/{$track->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tracks', ['id' => $track->id]);
    }

    public function test_get_album_reviews()
    {
        $album = Album::factory()->create();
        $album->reviews()->createMany([
            ['rating' => 50, 'body' => 'Comment 1'],
        ]);

        $response = $this->get("/albums/{$album->id}/reviews");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_store_album_review()
    {
        $album = Album::factory()->create();

        $response = $this->post("/albums/{$album->id}/reviews", [
            'rating' => 50,
            'body' => 'Comment 1',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'rating' => 50,
                'body' => 'Comment 1',
            ]
        ]);
    }

    public function test_dont_store_more_than_one_album_review()
    {
        $album = Album::factory()->create();
        $album->reviews()->create([
            'rating' => 50,
            'body' => 'Comment 1',
        ]);

        $response = $this->post("/albums/{$album->id}/reviews", [
            'rating' => 50,
            'body' => 'Comment 2',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('You can only review an album once');
    }

    public function test_update_album_review()
    {
        $album = Album::factory()->create();
        $review = $album->reviews()->create([
            'rating' => 50,
            'body' => 'Comment 1',
        ]);

        $response = $this->put("/albums/{$album->id}/reviews/{$review->id}", [
            'rating' => 60,
            'body' => 'Comment 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $review->id,
                'rating' => 60,
                'body' => 'Comment 2',
            ]
        ]);
    }

    public function test_delete_album_review()
    {
        $album = Album::factory()->create();
        $review = $album->reviews()->create([
            'rating' => 50,
            'body' => 'Comment 1',
        ]);

        $response = $this->delete("/albums/{$album->id}/reviews/{$review->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('album_reviews', ['id' => $review->id]);
    }

    public function test_get_album_genres()
    {
        $album = Album::factory()->create();
        $album->genres()->createMany([
            ['name' => 'Genre 1'],
            ['name' => 'Genre 2'],
        ]);

        $response = $this->get("/albums/{$album->id}/genres");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_store_album_genre()
    {
        $album = Album::factory()->create();

        $response = $this->post("/albums/{$album->id}/genres", [
            'name' => 'Genre 1',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Genre 1',
            ]
        ]);
    }

    public function test_delete_album_genre()
    {
        $album = Album::factory()->create();
        $genre = $album->genres()->create([
            'name' => 'Genre 1',
        ]);

        $response = $this->delete("/albums/{$album->id}/genres/{$genre->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('album_genre', ['id' => $genre->id]);
    }
}
