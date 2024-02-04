<?php

namespace Tests\Feature\Models;

use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_be_created()
    {
        $artist = Artist::factory()->create();

        $this->assertDatabaseHas('artists', [
            'id' => $artist->id,
        ]);
    }

    public function test_can_be_updated()
    {
        $artist = Artist::factory()->create();

        $artist->update([
            'name' => 'New Name',
            'description' => 'New Description',
            'type' => 'duo',
        ]);

        $this->assertDatabaseHas('artists', [
            'id' => $artist->id,
            'name' => 'New Name',
            'description' => 'New Description',
            'type' => 'duo',
        ]);
    }

    public function test_can_be_deleted()
    {
        $artist = Artist::factory()->create();

        $artist->delete();

        $this->assertDatabaseMissing('artists', [
            'id' => $artist->id,
        ]);
    }

    public function test_can_add_album()
    {
        $artist = Artist::factory()->create();

        $album = $artist->addAlbum([
            'title' => 'New Album',
            'description' => 'New Description',
        ]);

        $this->assertDatabaseHas('albums', [
            'title' => 'New Album',
            'description' => 'New Description',
            'artist_id' => $artist->id,
        ]);
    }

    public function test_can_delete_album()
    {
        $artist = Artist::factory()->create();
        $album = $artist->addAlbum([
            'title' => 'New Album',
            'description' => 'New Description',
        ]);

        $artist->deleteAlbum($album->id);

        $this->assertDatabaseMissing('albums', [
            'id' => $album->id,
        ]);
    }
}
