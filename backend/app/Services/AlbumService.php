<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Track;

class AlbumService
{
    public function create(array $data): Album
    {
        return Album::create($data);
    }

    public function update(array $data, Album $model): Album
    {
        $model->update($data);

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
}
