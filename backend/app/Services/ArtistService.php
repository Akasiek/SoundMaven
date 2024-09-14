<?php

namespace App\Services;

use App\Models\Artist;

class ArtistService
{
    public function create(array $data): Artist
    {
        $artist = Artist::create($data);

        if (isset($data['background_image'])) {
            $artist->attachBackgroundImage($data['background_image']);
        }

        return $artist;
    }

    public function update(array $data, Artist $model): Artist
    {
        $requestHasBackgroundImage = isset($data['background_image']);

        if ($requestHasBackgroundImage) {
            $model->detachBackgroundImage();
        }

        $model->update($data);

        if ($requestHasBackgroundImage) {
            $model->attachBackgroundImage($data['background_image']);
        }

        return $model;
    }

    public function delete(Artist $model): bool
    {
        return $model->delete();
    }
}
