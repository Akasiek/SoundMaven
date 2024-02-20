<?php

namespace Tests\Feature\Models;

use App\Models\Album;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_be_created()
    {
        $track = Track::factory()->create();

        $this->assertDatabaseHas('tracks', [
            'id' => $track->id,
        ]);
    }

    public function test_can_be_updated()
    {
        $album1 = Album::factory()->create();
        $album2 = Album::factory()->create();

        $track = Track::factory()->create([
            'album_id' => $album1->id,
        ]);

        $track->update([
            'title' => 'New Title',
            'length' => 300,
            'order' => 2,
            'album_id' => $album2->id,
        ]);

        $this->assertDatabaseHas('tracks', [
            'id' => $track->id,
            'title' => 'New Title',
            'length' => 300,
            'order' => 2,
            'album_id' => $album2->id,
        ]);
    }

    public function test_can_be_deleted()
    {
        $track = Track::factory()->create();

        $this->assertDatabaseHas('tracks', [
            'id' => $track->id,
        ]);

        $track->delete();

        $this->assertSoftDeleted('tracks', [
            'id' => $track->id,
        ]);
    }

    public function test_can_be_ordered()
    {
        $album = Album::factory()->create();
        $track1 = Track::factory()->create([
            'album_id' => $album->id,
            'order' => 2,
        ]);
        $track2 = Track::factory()->create([
            'album_id' => $album->id,
            'order' => 1,
        ]);
        $track3 = Track::factory()->create([
            'album_id' => $album->id,
            'order' => 3,
        ]);

        $tracks = Track::orderedAlbum($album->id)->get();

        $this->assertEquals($track2->id, $tracks[0]->id);
        $this->assertEquals($track1->id, $tracks[1]->id);
        $this->assertEquals($track3->id, $tracks[2]->id);
    }

    public function test_can_calculate_length_in_minutes()
    {
        $track = Track::factory()->create([
            'length' => 231
        ]);

        $this->assertEquals('03:51', $track->lengthInMinutes());
    }

    public function test_can_calculate_length_in_minutes_and_hours()
    {
        $track = Track::factory()->create([
            'length' => 3861
        ]);

        $this->assertEquals('01:04:21', $track->lengthInMinutes());
    }
}
