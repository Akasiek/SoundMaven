<?php

namespace App\Traits;

use App\Models\Abstract\Review;
use App\Models\AlbumReview;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasReviews
{
    public function reviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class);
    }

    public function addReview(array $data): Review
    {
        return $this->reviews()->create($data);
    }

    public function updateReview(Review $review, array $data): Review
    {
        $review->update($data);

        return $review;
    }

    public function deleteReview(Review $review): bool
    {
        return $review->delete();
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating');
    }
}
