<?php

namespace App\Services;

use App\Models\Album;

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
}
