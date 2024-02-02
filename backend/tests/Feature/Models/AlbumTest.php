<?php

namespace Tests\Feature\Models;

use App\Models\Album;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    public function test_models_can_be_created()
    {
        $album = Album::factory()->create();

        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
        ]);
    }
}
