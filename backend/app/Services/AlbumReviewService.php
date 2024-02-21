<?php

namespace App\Services;

use App\Models\AlbumReview;

class AlbumReviewService
{
    public function create(array $data): AlbumReview
    {
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
