<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArtistControllerTest extends ControllerWithAuthTestCase
{
    public function test_get_artists()
    {
        Artist::factory(3)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/artists');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonPath('meta.per_page', 25);
        $response->assertJsonPath('meta.total', 3);
    }

    public function test_artists_sort(): void
    {
        Artist::factory()->create(['name' => 'Artist 1']);
        Artist::factory()->create(['name' => 'Artist 2']);
        Artist::factory()->create(['name' => 'Artist 3']);

        $response = $this->get('/artists?sort=name');

        $response->assertJsonPath('data.0.name', 'Artist 1');
        $response->assertJsonPath('data.1.name', 'Artist 2');
        $response->assertJsonPath('data.2.name', 'Artist 3');
    }

    public function test_artists_filter(): void
    {
        $a = Artist::factory()->create(['name' => 'Artist 1', 'type' => 'solo']);
        Artist::factory()->create(['name' => 'Artist 2', 'type' => 'band']);
        Artist::factory()->create(['name' => 'Artist 3', 'type' => 'solo']);

        $response = $this->get('/artists?filter[type]=solo');

        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.name', 'Artist 1');
        $response->assertJsonPath('data.1.name', 'Artist 3');

        $response = $this->get('/artists?filter[type]=band');

        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', 'Artist 2');

        $a->albums()->create(['title' => 'Album 1']);
        $response = $this->get("/artists?filter[albums.title]={$a->albums->first()->title}");

        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', 'Artist 1');
    }

    public function test_cannot_see_deleted_artists()
    {
        Artist::factory(3)->create();

        $artist = Artist::inRandomOrder()->first();
        $artist->delete();

        $response = $this->get('/artists');

        $response->assertJsonCount(2, 'data');
    }

    public function test_get_artist()
    {
        $artist = Artist::create([
            'name' => 'Artist 1',
            'description' => 'Description 1',
            'type' => 'solo',
        ]);

        $response = $this->get("/artists/{$artist->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $artist->id,
                'name' => 'Artist 1',
                'description' => 'Description 1',
                'type' => 'solo',
            ]
        ]);
    }

    public function test_store_artist()
    {
        $response = $this->post('/artists', [
            'name' => 'Artist 1',
            'description' => 'Description 1',
            'type' => 'solo',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Artist 1',
                'description' => 'Description 1',
                'type' => 'solo',
            ]
        ]);
    }

    public function test_store_artist_with_background_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('background.jpg');

        $response = $this->post('/artists', [
            'name' => 'Artist 1',
            'description' => 'Description 1',
            'type' => 'solo',
            'background_image' => $image,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Artist 1',
                'description' => 'Description 1',
                'type' => 'solo',
                // Don't check 'background_image' because of random storage path
            ]
        ]);

        $this->assertDatabaseHas('media', [
            'model_type' => Artist::class,
            'model_id' => $response->json('data.id'),
            'name' => 'artist-1-background',
        ]);
    }

    public function test_update_artist()
    {
        $artist = Artist::create([
            'name' => 'Artist 1',
            'description' => 'Description 1',
            'type' => 'solo',
        ]);

        $response = $this->put("/artists/{$artist->id}", [
            'name' => 'Artist 2',
            'description' => 'Description 2',
            'type' => 'band',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $artist->id,
                'name' => 'Artist 2',
                'description' => 'Description 2',
                'type' => 'band',
            ]
        ]);

        // Test patch
        $response = $this->patch("/artists/{$artist->id}", [
            'name' => 'Artist 3',
        ]);
        $response->assertJson([
            'data' => [
                'id' => $artist->id,
                'name' => 'Artist 3',
                'description' => 'Description 2',
                'type' => 'band',
            ]
        ]);
    }

    public function test_update_artist_with_background_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('background.jpg');

        $artist = Artist::create([
            'name' => 'Artist 1',
            'description' => 'Description 1',
            'type' => 'solo',
        ]);

        $response = $this->put("/artists/{$artist->id}", [
            'name' => 'Artist 2',
            'description' => 'Description 2',
            'type' => 'band',
            'background_image' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => 'Artist 2',
                'description' => 'Description 2',
                'type' => 'band',
                // Don't check 'background_image' because of random storage path
            ]
        ]);

        $this->assertDatabaseHas('media', [
            'model_type' => Artist::class,
            'model_id' => $response->json('data.id'),
            'name' => 'artist-2-background',
        ]);
    }

    public function test_delete_artist()
    {
        $artist = Artist::create([
            'name' => 'Artist 1',
            'description' => 'Description 1',
            'type' => 'solo',
        ]);

        $response = $this->delete("/artists/{$artist->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('artists', ['id' => $artist->id]);
    }
}
