<?php

namespace Models;

use App\Models\AlbumTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_be_created()
    {
        $albumTag = AlbumTag::factory()->create();

        $this->assertDatabaseHas('album_tags', [
            'id' => $albumTag->id,
        ]);
    }

    public function test_can_be_updated()
    {
        $albumTag = AlbumTag::factory()->create([
            'name' => 'Old Name',
        ]);

        $albumTag->update([
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('album_tags', [
            'id' => $albumTag->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_be_deleted()
    {
        $albumTag = AlbumTag::factory()->create();

        $albumTag->delete();

        $this->assertDatabaseMissing('album_tags', [
            'id' => $albumTag->id,
        ]);
    }
}
