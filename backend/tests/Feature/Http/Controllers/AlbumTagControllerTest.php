<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumTag;

class AlbumTagControllerTest extends ControllerWithAuthTestCase
{
    public function test_get_album_tags()
    {
        AlbumTag::factory(3)->create();
        $response = $this->get('/album-tags');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonPath('meta.per_page', 25);
        $response->assertJsonPath('meta.total', 3);
    }

    public function test_get_album_tag()
    {
        $tag = AlbumTag::factory()->create();
        $response = $this->get("/album-tags/{$tag->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'albums_count' => 0,
            ],
        ]);

        $tag = AlbumTag::factory()->hasAlbums(3)->create();
        $response = $this->get("/album-tags/{$tag->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
                'albums_count' => 3,
            ],
        ]);
    }

    public function test_album_tag_sort(): void
    {
        AlbumTag::factory()->create(['name' => 'Tag 3']);
        AlbumTag::factory()->create(['name' => 'Tag 1']);
        AlbumTag::factory()->create(['name' => 'Tag 2']);

        $response = $this->get('/album-tags?sort=name');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.name', 'Tag 1');
        $response->assertJsonPath('data.1.name', 'Tag 2');
        $response->assertJsonPath('data.2.name', 'Tag 3');

        Album::factory(4)->create();

        AlbumTag::where('name', 'Tag 3')->firstOrFail()->albums()->attach(Album::all()->random(2));
        AlbumTag::where('name', 'Tag 2')->firstOrFail()->albums()->attach(Album::all()->random(1));

        $response = $this->get('/album-tags?sort=albums_count');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.name', 'Tag 1');
        $response->assertJsonPath('data.1.name', 'Tag 2');
        $response->assertJsonPath('data.2.name', 'Tag 3');
    }

    public function test_album_tag_filter(): void
    {
        AlbumTag::factory()->create(['name' => 'Tag 1']);
        AlbumTag::factory()->create(['name' => 'Tag 2']);
        AlbumTag::factory()->create(['name' => 'Tag 3']);

        $response = $this->get('/album-tags?filter[name]=Tag 1');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', 'Tag 1');

        $album = Album::factory()->create();

        AlbumTag::where('name', 'Tag 1')->firstOrFail()->albums()->attach($album);

        $response = $this->get("/album-tags?filter[albums.title]={$album->title}");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', 'Tag 1');
    }

    public function test_store_album_tag()
    {
        $response = $this->post('/album-tags', [
            'name' => 'Tag 1',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Tag 1',
                'slug' => 'tag-1',
            ],
        ]);
    }

    public function test_update_album_tag()
    {
        $tag = AlbumTag::factory()->create();
        $response = $this->put("/album-tags/{$tag->id}", [
            'name' => 'Tag 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => 'Tag 2',
                'slug' => 'tag-2',
            ],
        ]);
    }

    public function test_delete_album_tag()
    {
        $tag = AlbumTag::factory()->create();
        $response = $this->delete("/album-tags/{$tag->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('album_tags', ['id' => $tag->id]);
    }
}
