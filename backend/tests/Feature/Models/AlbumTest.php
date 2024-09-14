<?php

namespace Tests\Feature\Models;

use App\Models\Album;
use App\Models\AlbumTag;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_be_created()
    {
        $album = Album::factory()->create();

        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
        ]);
    }

    public function test_can_be_updated()
    {
        $album = Album::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old Description',
            'release_date' => '2020-01-01',
            'type' => 'LP',
            'artist_id' => Artist::factory()->create()->id,
        ]);

        $newArtist = Artist::factory()->create();

        $album->update([
            'title' => 'New Title',
            'description' => 'New Description',
            'release_date' => '2021-01-01',
            'type' => 'EP',
            'artist_id' => $newArtist->id,
        ]);

        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
            'title' => 'New Title',
            'slug' => 'new-title',
            'description' => 'New Description',
            'release_date' => '2021-01-01',
            'type' => 'EP',
            'artist_id' => $newArtist->id,
        ]);
    }

    public function test_can_be_deleted()
    {
        $album = Album::factory()->create();

        $album->delete();

        $this->assertSoftDeleted('albums', [
            'id' => $album->id,
        ]);
    }

    public function test_can_attach_cover_image(): void
    {
        $album = Album::factory()->create();

        $album->attachCoverImage('tests/Assets/album_cover.jpg');

        $this->assertDatabaseHas('media', [
            'name' => "$album->slug-cover",
            'file_name' => "$album->slug-cover.jpg",
            'model_id' => $album->id,
            'model_type' => Album::class,
            'collection_name' => 'album-covers',
        ]);

        $album->clearMediaCollection('album-covers');
    }

    public function test_can_detach_cover_image(): void
    {
        $album = Album::factory()->create();

        $album->attachCoverImage('tests/Assets/album_cover.jpg');
        $album->detachCoverImage();

        $this->assertDatabaseMissing('media', [
            'model_id' => $album->id,
            'model_type' => Album::class,
            'collection_name' => 'album-covers',
        ]);
    }

    public function test_can_add_review()
    {
        $album = Album::factory()->create();

        $album->reviews()->create([
            'rating' => 50,
            'body' => 'New Review. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $this->assertDatabaseHas('album_reviews', [
            'rating' => 50,
            'body' => 'New Review. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'album_id' => $album->id,
        ]);

    }

    public function test_can_delete_review()
    {
        $album = Album::factory()->create();

        $review = $album->reviews()->create([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->reviews()->delete($review->id);

        $this->assertSoftDeleted('album_reviews', [
            'album_id' => $album->id,
        ]);
    }

    public function test_can_get_average_rating()
    {
        $album = Album::factory()->create();

        $album->reviews()->create([
            'rating' => 50,
            'body' => 'New Review',
        ]);

        $album->reviews()->create([
            'rating' => 100,
            'body' => 'New Review',
        ]);

        $this->assertEquals(75, $album->averageRating());

        $album->reviews()->where(['rating' => 100])->delete();

        $this->assertEquals(50, $album->averageRating());
    }

    public function test_can_attach_genre()
    {
        $album = Album::factory()->create();
        $genre = Genre::factory()->create();

        $album->genres()->attach($genre->id);

        $this->assertDatabaseHas('album_genre', [
            'album_id' => $album->id,
            'genre_id' => $genre->id,
        ]);
    }

    public function test_can_detach_genre()
    {
        $album = Album::factory()->create();
        $genre = Genre::factory()->create();

        $album->genres()->attach($genre->id);
        $album->genres()->detach($genre->id);

        $this->assertDatabaseMissing('album_genre', [
            'album_id' => $album->id,
            'genre_id' => $genre->id,
        ]);
    }

    public function test_can_get_genres_count()
    {
        $album = Album::factory()->create();

        for ($i = 0; $i < 6; $i++) {
            $genre = Genre::factory()->create();
            $album->genres()->attach($genre->id);
        }

        $this->assertEquals(6, $album->genres()->count());
    }

    public function test_can_attach_tag()
    {
        $album = Album::factory()->create();
        $tag = AlbumTag::factory()->create();

        $album->tags()->attach($tag->id);

        $this->assertDatabaseHas('album_album_tag', [
            'album_id' => $album->id,
            'album_tag_id' => $tag->id,
        ]);
    }

    public function test_can_detach_tag()
    {
        $album = Album::factory()->create();
        $tag = AlbumTag::factory()->create();

        $album->tags()->attach($tag->id);
        $album->tags()->detach($tag->id);

        $this->assertDatabaseMissing('album_album_tag', [
            'album_id' => $album->id,
            'album_tag_id' => $tag->id,
        ]);
    }

    public function test_can_add_track()
    {
        $album = Album::factory()->create();

        $album->tracks()->create([
            'title' => 'New Track',
            'length' => 250,
            'order' => 1,
        ]);

        $this->assertDatabaseHas('tracks', [
            'album_id' => $album->id,
            'title' => 'New Track',
            'length' => 250,
            'order' => 1,
        ]);
    }

    public function test_can_delete_track()
    {
        $album = Album::factory()->create();
        $track = $album->tracks()->create([
            'title' => 'New Track',
            'length' => 200,
            'order' => 1,
        ]);

        $album->tracks()->delete($track->id);

        $this->assertSoftDeleted('tracks', [
            'album_id' => $album->id,
        ]);
    }
}
