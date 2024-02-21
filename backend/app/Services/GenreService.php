<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function create(array $data): Genre
    {
        return Genre::create($data);
    }

    public function update(array $data, Genre $model): Genre
    {
        $model->update($data);

        return $model;
    }

    public function delete(Genre $model): bool
    {
        return $model->delete();
    }
}
