<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumTag;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AlbumControllerTest extends ControllerWithAuthTestCase
{
    public function test_get_albums()
    {
        Album::factory(3)->create();

        $response = $this->get('/albums');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_cannot_see_deleted_albums()
    {
        Album::factory(3)->create();

        $album = Album::inRandomOrder()->first();
        $album->delete();

        $response = $this->get('/albums');

        $response->assertJsonCount(2, 'data');
    }

    public function test_get_album()
    {
        $artist = Artist::factory()->create();
        $album = Album::create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'type' => 'LP',
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
                'type' => 'LP',
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
            'type' => 'LP',
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
                'type' => 'LP',
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
                'type' => 'LP',
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
            'type' => 'LP',
            'artist_id' => $artist->id,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Album 1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
                'type' => 'LP',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);
    }

    /**
     * This function tests how the Album model behaves when the title is hard to slugify.
     * It should not leave the slug empty but should give it a slug of "untitled".
     */
    public function test_store_album_with_hard_title()
    {
        $artist = Artist::factory()->create();
        $response = $this->post('/albums', [
            // It's a reference to Sigur Rós' album "()"
            'title' => '()',
            'description' => 'Album with a hard title to slugify',
            'release_date' => '2021-01-01',
            'type' => 'LP',
            'artist_id' => $artist->id,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => '()',
                'slug' => 'untitled',
                'description' => 'Album with a hard title to slugify',
            ]
        ]);

        // Add another album with the same title
        // Make sure that the slug is unique
        $response = $this->post('/albums', [
            'title' => '() () ()',
            'description' => 'Another album with a hard title to slugify',
            'release_date' => '2021-01-01',
            'type' => 'LP',
            'artist_id' => $artist->id,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => '() () ()',
                'slug' => 'untitled-2',
                'description' => 'Another album with a hard title to slugify',
            ]
        ]);
    }

    public function test_store_album_with_cover_image(): void
    {
        $artist = Artist::factory()->create();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('album_cover.jpg');

        $response = $this->post('/albums', [
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'type' => 'LP',
            'artist_id' => $artist->id,
            'cover_image' => $image,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Album 1',
                'description' => 'Description 1',
                'release_date' => '2021-01-01',
                'type' => 'LP',
                'artist' => [
                    'id' => $artist->id,
                    'name' => $artist->name,
                ],
            ]
        ]);

        $this->assertDatabaseHas('media', [
            'model_type' => Album::class,
            'model_id' => $response->json('data.id'),
            'name' => 'album-1-cover',
        ]);
    }

    public function test_update_album()
    {
        $album = Album::factory()->create([
            'title' => 'Album 1',
            'description' => 'Description 1',
            'release_date' => '2021-01-01',
            'type' => 'LP',
        ]);

        $newArtist = Artist::factory()->create();
        $response = $this->put("/albums/{$album->id}", [
            'title' => 'Album 2',
            'description' => 'Description 2',
            'release_date' => '2021-01-02',
            'type' => 'EP',
            'artist_id' => $newArtist->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => 'Album 2',
                'description' => 'Description 2',
                'release_date' => '2021-01-02',
                'type' => 'EP',
                'artist' => [
                    'id' => $newArtist->id,
                    'name' => $newArtist->name,
                ],
            ]
        ]);
    }

    public function test_update_albums_one_field()
    {
        $album = Album::factory()->create();

        $response = $this->patch("/albums/{$album->id}", [
            'description' => 'Description 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $album->id,
                'title' => $album->title,
                'description' => 'Description 2',
                'release_date' => $album->release_date,
                'type' => $album->type,
                'artist' => [
                    'id' => $album->artist->id,
                    'name' => $album->artist->name,
                ],
            ]
        ]);
    }

    public function test_update_album_with_cover_image(): void
    {
        $album = Album::factory()->create();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('album_cover.jpg');

        $response = $this->patch("/albums/{$album->id}", [
            'cover_image' => $image,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('media', [
            'model_type' => Album::class,
            'model_id' => $album->id,
            'name' => "{$album->slug}-cover",
        ]);
    }

    public function test_delete_album()
    {
        $album = Album::factory()->create();

        $response = $this->delete("/albums/{$album->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('albums', ['id' => $album->id]);
    }

    public function test_get_tracks()
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

    public function test_get_reviews()
    {
        $album = Album::factory()->create();
        $album->reviews()->createMany([
            ['rating' => 50, 'body' => 'Comment 1'],
        ]);

        $response = $this->get("/albums/{$album->id}/reviews");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_get_genres()
    {
        $album = Album::factory()->hasGenres(2)->create();
        $response = $this->get("/albums/{$album->id}/genres");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_add_genre()
    {
        $album = Album::factory()->create();
        $genre = Genre::factory()->create();

        $response = $this->post("/albums/{$album->id}/genres/{$genre->id}");

        $response->assertStatus(201);

        $response = $this->get("/albums/{$album->id}/genres");
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_remove_genre()
    {
        $album = Album::factory()->create();
        $genre = Genre::factory()->create();
        $album->genres()->attach($genre->id);

        $response = $this->delete("/albums/{$album->id}/genres/{$genre->id}");

        $response->assertStatus(204);

        $response = $this->get("/albums/{$album->id}/genres");
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_get_tags()
    {
        $album = Album::factory()->hasTags(2)->create();
        $response = $this->get("/albums/{$album->id}/tags");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_add_tag()
    {
        $album = Album::factory()->create();
        $tag = AlbumTag::factory()->create();

        $response = $this->post("/albums/{$album->id}/tags/{$tag->id}");

        $response->assertStatus(201);

        $response = $this->get("/albums/{$album->id}/tags");
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_remove_tag()
    {
        $album = Album::factory()->create();
        $tag = AlbumTag::factory()->create();
        $album->tags()->attach($tag->id);

        $response = $this->delete("/albums/{$album->id}/tags/{$tag->id}");

        $response->assertStatus(204);

        $response = $this->get("/albums/{$album->id}/tags");
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }
}
