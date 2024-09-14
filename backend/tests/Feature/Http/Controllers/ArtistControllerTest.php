<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArtistControllerTest extends ControllerWithAuthTestCase
{
    use RefreshDatabase;

    public function test_get_artists()
    {
        Artist::factory(3)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/artists');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
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
