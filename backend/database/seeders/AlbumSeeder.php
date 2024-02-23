<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;

class AlbumSeeder extends CsvSeeder
{
    protected string $fileName = 'database/seeders/data/albums.csv';
    protected string $model = Album::class;

    protected function getMapping(): array
    {
        return [
            'artist_id' => 0,
            'title' => 1,
            'release_date' => 2,
            'type' => 3,
        ];
    }

    protected function specialValueMappings(): array
    {
        return [
            'artist_id' => fn($value) => Artist::where('name', $value)->first()->id,
        ];
    }
}
