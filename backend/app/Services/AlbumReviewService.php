<?php

namespace App\Services;

use App\Models\AlbumReview;

class AlbumReviewService
{
    public function create(array $data): AlbumReview
    {
        // Check if the user has already reviewed this album
        $userReview = AlbumReview::where('album_id', $data['album_id'])
            ->where('created_by', auth()->id())
            ->first();
        if ($userReview) {
            // Send it to update
            return $this->update($data, $userReview);
        }

        return AlbumReview::create($data);
    }

    public function update(array $data, AlbumReview $model): AlbumReview
    {
        $model->update($data);

        return $model;
    }

    public function delete(AlbumReview $model): bool
    {
        return $model->delete();
    }
}
