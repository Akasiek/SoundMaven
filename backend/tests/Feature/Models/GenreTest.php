<?php

namespace Tests\Feature\Models;

use App\Models\Album;
use App\Models\Genre;
use Database\Seeders\GenreSeeder;
use Tests\RefreshingTestCase;

class GenreTest extends RefreshingTestCase
{
    public function test_can_seed()
    {
        $this->seed(GenreSeeder::class);

        $this->assertDatabaseHas('genres', [
            'name' => 'Rock',
        ]);
        $this->assertDatabaseHas('genres', [
            'name' => 'Synth-pop',
        ]);
        $this->assertDatabaseHas('genres', [
            'name' => 'Progressive Rock',
        ]);
    }

    public function test_can_be_created()
    {
        $genre = Genre::factory()->create();

        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
        ]);
    }

    public function test_can_be_updated()
    {
        $genre = Genre::factory()->create();

        $genre->update([
            'name' => 'New Name',
            'description' => 'New Description',
        ]);

        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name' => 'New Name',
            'description' => 'New Description',
        ]);
    }

    public function test_can_be_deleted()
    {
        $genre = Genre::factory()->create();

        $genre->delete();

        $this->assertSoftDeleted('genres', [
            'id' => $genre->id,
        ]);
    }

    public function test_can_count_all_albums()
    {
        $genre = Genre::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $genre->albums()->create(Album::factory()->make()->toArray());
        }

        $this->assertEquals(5, $genre->albums()->count());
    }

    public function test_can_add_parent()
    {
        $parent = Genre::factory()->create();
        $child = Genre::factory()->create();

        $child->parent()->associate($parent)->save();

        $this->assertEquals($parent->id, $child->parent->id);
    }

    public function test_can_add_children()
    {
        $parent = Genre::factory()->create();
        $child = Genre::factory()->create();

        $parent->children()->save($child);

        $this->assertEquals($child->id, $parent->children->first()->id);
    }
}
