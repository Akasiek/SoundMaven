<?php

namespace App\Services;

use App\Models\Track;

class TrackService
{
    public function create(array $data): Track
    {
        return Track::create($data);
    }

    public function update(array $data, Track $model): Track
    {
        $model->update($data);

        return $model;
    }

    public function delete(Track $model): bool
    {
        return $model->delete();
    }
}
