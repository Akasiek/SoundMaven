<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackControllerTest extends ControllerWithAuthTestCase
{
    use RefreshDatabase;

    public function test_get_tracks()
    {
        Track::factory(3)->create();

        $response = $this->get('/tracks');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_cannot_see_deleted_tracks()
    {
        Track::factory(3)->create();

        $track = Track::inRandomOrder()->first();
        $track->delete();

        $response = $this->get('/tracks');

        $response->assertJsonCount(2, 'data');
    }

    public function test_get_track()
    {
        $track = Track::factory()->create();

        $response = $this->get("tracks/{$track->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $track->id,
                'title' => $track->title,
                'length' => $track->length,
                'order' => $track->order,
                'album' => [
                    'id' => $track->album->id,
                    'title' => $track->album->title,
                ]
            ]
        ]);
    }

    public function test_store_track()
    {
        $album = Album::factory()->create();

        $response = $this->post("tracks", [
            'title' => 'Track 1',
            'length' => 180,
            'order' => 1,
            'album_id' => $album->id,
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

    public function test_get_album_tracks()
    {
        $album = Album::factory()->create();
        $album->tracks()->createMany([
            ['title' => 'Track 1', 'length' => 180, 'order' => 1],
            ['title' => 'Track 2', 'length' => 240, 'order' => 2],
            ['title' => 'Track 3', 'length' => 300, 'order' => 3],
        ]);

        $response = $this->get("/tracks?filter[album.title]={$album->title}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                ['title' => 'Track 1', 'length' => 180, 'order' => 1],
                ['title' => 'Track 2', 'length' => 240, 'order' => 2],
                ['title' => 'Track 3', 'length' => 300, 'order' => 3],
            ]
        ]);

        $slugResponse = $this->get("/tracks?filter[album.slug]={$album->slug}");

        $this->assertEquals($response->json(), $slugResponse->json());
    }

    public function test_cannot_store_album_track_with_duplicate_order()
    {
        $album = Album::factory()->create();
        $album->tracks()->create([
            'title' => 'Track 1',
            'length' => 180,
            'order' => 1,
        ]);

        $response = $this->post("/tracks", [
            'title' => 'Track 2',
            'length' => 220,
            'order' => 1,
            'album_id' => $album->id,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('order');
    }

    public function test_update_track_using_put()
    {
        $album = Album::factory()->create();
        $track = Track::factory()->create();

        $response = $this->put("tracks/{$track->id}", [
            'title' => 'Track 2',
            'length' => 220,
            'order' => 2,
            'album_id' => $album->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $track->id,
                'title' => 'Track 2',
                'length' => 220,
                'order' => 2,
                'album' => [
                    'id' => $album->id,
                    'title' => $album->title,
                ]
            ]
        ]);
    }

    public function test_update_track_using_patch()
    {
        $album = Album::factory()->create();
        $track = Track::factory()->create([
            'album_id' => $album->id,
            'order' => 1,
        ]);

        $response = $this->patch("tracks/{$track->id}", [
            'title' => 'Track 2',
            'length' => 220,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $track->id,
                'title' => 'Track 2',
                'length' => 220,
                'order' => 1,
                'album' => [
                    'id' => $album->id,
                    'title' => $album->title,
                ]
            ]
        ]);
    }

    public function test_delete_track()
    {
        $track = Track::factory()->create();

        $response = $this->delete("tracks/{$track->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('tracks', ['id' => $track->id]);
    }
}
