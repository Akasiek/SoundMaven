<?php

namespace App\Services;

use App\Models\Album;
use App\Models\AlbumReview;
use App\Models\Track;

class AlbumService
{
    public function create(array $data): Album
    {
        $album = Album::create($data);

        if (isset($data['cover_image'])) {
            $album->attachCoverImage($data['cover_image']);
        }

        return $album;
    }

    public function update(array $data, Album $model): Album
    {
        $requestHasCoverImage = isset($data['cover_image']);

        if ($requestHasCoverImage) {
            $model->detachCoverImage();
        }

        $model->update($data);

        if ($requestHasCoverImage) {
            $model->attachCoverImage($data['cover_image']);
        }

        return $model;
    }

    public function delete(Album $model): bool
    {
        return $model->delete();
    }

    public function addTrack(array $data, Album $model): Track
    {
        $data['album_id'] = $model->id;

        return $model->tracks()->create($data);
    }

    public function addReview(array $data, Album $model): AlbumReview
    {
        $data['album_id'] = $model->id;

        return $model->reviews()->create($data);
    }
}
