<?php

namespace App\Services;

use App\Models\Artist;

class ArtistService
{
    public function create(array $data): Artist
    {
        return Artist::create($data);
    }

    public function update(array $data, Artist $model): Artist
    {
        $model->update($data);

        return $model;
    }

    public function delete(Artist $model): bool
    {
        return $model->delete();
    }
}
