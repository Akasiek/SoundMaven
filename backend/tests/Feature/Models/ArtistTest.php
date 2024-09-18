<?php

namespace Tests\Feature\Models;

use App\Models\Artist;
use Tests\RefreshingTestCase;

class ArtistTest extends RefreshingTestCase
{
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

        $this->assertSoftDeleted('artists', [
            'id' => $artist->id,
        ]);
    }

    public function test_can_attach_background_image(): void
    {
        $artist = Artist::factory()->create();

        $artist->attachBackgroundImage('tests/Assets/artist_background.jpg');

        $this->assertDatabaseHas('media', [
            'name' => "{$artist->slug}-background",
            'file_name' => "{$artist->slug}-background.jpg",
            'model_id' => $artist->id,
            'model_type' => Artist::class,
            'collection_name' => 'artist-backgrounds',
        ]);

        $artist->clearMediaCollection('artist-backgrounds');
    }

    public function test_can_detach_background_image(): void
    {
        $artist = Artist::factory()->create();

        $artist->attachBackgroundImage('tests/Assets/artist_background.jpg');
        $artist->detachBackgroundImage();

        $this->assertDatabaseMissing('media', [
            'model_id' => $artist->id,
            'model_type' => Artist::class,
            'collection_name' => 'artist-backgrounds',
        ]);
    }

    public function test_can_add_albums()
    {
        $artist = Artist::factory()->create();

        $artist->albums()->create([
            'title' => 'New Album',
            'description' => 'New Description',
        ]);

        $artist->albums()->create([
            'title' => 'Another Album',
            'description' => 'Another Description',
        ]);

        $this->assertDatabaseHas('albums', [
            'title' => 'New Album',
            'description' => 'New Description',
        ]);

        $this->assertDatabaseHas('albums', [
            'title' => 'Another Album',
            'description' => 'Another Description',
        ]);
    }

    public function test_can_delete_album()
    {
        $artist = Artist::factory()->create();
        $album = $artist->albums()->create([
            'title' => 'New Album',
            'description' => 'New Description',
        ]);

        $artist->albums()->delete($album->id);

        $this->assertSoftDeleted('albums', [
            'id' => $album->id,
        ]);
    }
}
