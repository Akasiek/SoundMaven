<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Album;
use App\Models\Genre;

class GenreControllerTest extends ControllerWithAuthTestCase
{
    public function test_get_genres()
    {
        Genre::factory(3)->create([
            'parent_id' => null,
        ]);

        $response = $this->get('/genres');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_get_genre()
    {
        $genre = Genre::factory()->create();

        $response = $this->get("genres/{$genre->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $genre->id,
                'name' => $genre->name,
                'description' => $genre->description,
            ]
        ]);
    }

    public function test_get_genres_albums()
    {
        $genre = Genre::factory()->create();
        $genre->albums()->saveMany([
            Album::factory()->make(),
            Album::factory()->make(),
        ]);

        $response = $this->get("genres/{$genre->id}/albums");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_store_genre()
    {
        $response = $this->post("genres", [
            'name' => 'Genre 1',
            'description' => 'Description 1',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Genre 1',
                'description' => 'Description 1',
            ]
        ]);
    }

    public function test_update_genre_using_put()
    {
        $genre = Genre::factory()->create();

        $response = $this->put("genres/{$genre->id}", [
            'name' => 'Genre 2',
            'description' => 'Description 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $genre->id,
                'name' => 'Genre 2',
                'description' => 'Description 2',
            ]
        ]);
    }

    public function test_update_genre_using_patch()
    {
        $genre = Genre::factory()->create();

        $response = $this->patch("genres/{$genre->id}", [
            'name' => 'Genre 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $genre->id,
                'name' => 'Genre 2',
                'description' => $genre->description,
            ]
        ]);
    }

    public function test_delete_genre()
    {
        $genre = Genre::factory()->create();

        $response = $this->delete("genres/{$genre->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('genres', [
            'id' => $genre->id,
        ]);
    }
}
