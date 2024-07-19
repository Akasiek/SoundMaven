<?php

namespace Http\Controllers;

use App\Models\AlbumTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controllers\ControllerWithAuthTestCase;

class AlbumTagControllerTest extends ControllerWithAuthTestCase
{
    use RefreshDatabase;

    public function test_get_album_tags()
    {
        AlbumTag::factory(3)->create();
        $response = $this->get("/album-tags");

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
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
            ]
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
            ]
        ]);
    }

    public function test_store_album_tag()
    {
        $response = $this->post("/album-tags", [
            'name' => 'Tag 1',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Tag 1',
                'slug' => 'tag-1',
            ]
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
            ]
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
