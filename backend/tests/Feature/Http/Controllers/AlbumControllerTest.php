<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumControllerTest extends ControllerWithAuthTestCase
{
    use RefreshDatabase;

    public function test_get_albums()
    {
        Album::factory(3)->create();

        $response = $this->get('/albums');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_get_album()
    {
        $artist = Artist::factory()->create();
        $album = Album::create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'artist_id' => $artist->id,
        ]);

        $response = $this->get("/albums/{$album->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => 'Album 1',
                'slug' => 'album-1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);
    }

    public function test_get_same_album_with_uuid_and_slug()
    {
        $artist = Artist::factory()->create();
        $album = Album::create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'artist_id' => $artist->id,
        ]);

        $response = $this->get("/albums/{$album->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => 'Album 1',
                'slug' => 'album-1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);

        $response = $this->get("/albums/{$album->slug}");
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => 'Album 1',
                'slug' => 'album-1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);

        $this->assertEquals($response->json(), $response->json());
    }

    public function test_store_album()
    {
        $artist = Artist::factory()->create();
        $response = $this->post('/albums', [
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'artist_id' => $artist->id,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Album 1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);
    }

    public function test_update_album()
    {
        $artist = Artist::factory()->create();
        $album = Album::create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'artist_id' => $artist->id,
        ]);

        $newArtist = Artist::factory()->create();
        $response = $this->put("/albums/{$album->id}", [
            'title' => 'Album 2',
            'description' => 'Description 2',
            'release_date' => '2021-01-02',
            'artist_id' => $newArtist->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => 'Album 2',
                'description' => 'Description 2',
                'release_date' => '2021-01-02',
                'artist' => [
                    'id' => $newArtist->id,
                    'name' => $newArtist->name,
                ],
            ]
        ]);
    }

    public function test_update_albums_one_field()
    {
        $artist = Artist::factory()->create();
        $album = Album::create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'artist_id' => $artist->id,
        ]);

        $response = $this->patch("/albums/{$album->id}", [
            'description' => 'Description 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => 'Album 1',
                'description' => 'Description 2',
                'release_date' => '2021-01-01',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);

    }

    public function test_delete_album()
    {
        $arist = Artist::factory()->create();
        $album = Album::create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'artist_id' => $arist->id,
        ]);

        $response = $this->delete("/albums/{$album->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }

    public function test_get_album_tracks()
    {
        $album = Album::factory()->create();
        $album->tracks()->createMany([
            ['title' => 'Track 1', 'length' => 180, 'order' => 1],
            ['title' => 'Track 2', 'length' => 240, 'order' => 2],
            ['title' => 'Track 3', 'length' => 300, 'order' => 3],
        ]);

        $response = $this->get("/albums/{$album->id}/tracks");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                ['title' => 'Track 1', 'length' => 180, 'order' => 1],
                ['title' => 'Track 2', 'length' => 240, 'order' => 2],
                ['title' => 'Track 3', 'length' => 300, 'order' => 3],
            ]
        ]);
    }

    public function test_store_album_track()
    {
        $album = Album::factory()->create();

        $response = $this->post("/albums/{$album->id}/tracks", [
            'title' => 'Track 1',
            'length' => 180,
            'order' => 1,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Track 1',
                'length' => 180,
                'order' => 1,
                'album' => [
                    'id' => $album->id,
                    'title' => $album->title,
                ]
            ]
        ]);
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
