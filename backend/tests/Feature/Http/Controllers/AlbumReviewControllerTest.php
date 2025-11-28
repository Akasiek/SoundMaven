<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\AlbumReview;

class AlbumReviewControllerTest extends ControllerWithAuthTestCase
{
    public function test_get_reviews()
    {
        AlbumReview::factory(3)->create();

        $response = $this->get('/album-reviews');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonPath('meta.per_page', 25);
        $response->assertJsonPath('meta.total', 3);
    }

    public function test_cannot_see_deleted_reviews()
    {
        $reviews = AlbumReview::factory(3)->create();
        $reviews[0]->delete();

        $response = $this->get('/album-reviews');

        $response->assertJsonCount(2, 'data');
    }

    public function test_get_review()
    {
        $review = AlbumReview::factory()->create();

        $response = $this->get("/album-reviews/{$review->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'body' => $review->body,
                'album' => [
                    'id' => $review->album->id,
                    'title' => $review->album->title,
                ],
                'creator' => [
                    'name' => $review->creator->name,
                    'email' => $review->creator->email,
                ],
            ],
        ]);
    }

    public function test_store_review()
    {
        $review = AlbumReview::factory()->make();

        $response = $this->post('/album-reviews', $review->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('album_reviews', $review->toArray());
    }

    public function test_cannot_store_more_than_one_review_for_one_album()
    {
        $review = AlbumReview::factory()->create();

        $response = $this->post('/album-reviews', $review->toArray());

        $response->assertStatus(422);

        $review->delete();

        $response = $this->post('/album-reviews', $review->toArray());

        $response->assertStatus(201);
    }

    public function test_update_review_using_put()
    {
        $review = AlbumReview::factory()->create();
        $newReview = AlbumReview::factory()->make();

        $response = $this->put("/album-reviews/{$review->id}", $newReview->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('album_reviews', $newReview->toArray());
    }

    public function test_update_review_using_patch()
    {
        $review = AlbumReview::factory()->create([
            'rating' => 100,
        ]);

        $response = $this->patch("/album-reviews/{$review->id}", [
            'rating' => 50,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('album_reviews', [
            'id' => $review->id,
            'rating' => 50,
        ]);
    }

    public function test_delete_review()
    {
        $review = AlbumReview::factory()->create();

        $response = $this->delete("/album-reviews/{$review->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('album_reviews', [
            'id' => $review->id,
        ]);
    }
}
