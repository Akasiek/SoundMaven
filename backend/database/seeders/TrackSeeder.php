<?php

namespace Database\Seeders;

use App\Helpers\TimeToSeconds;
use App\Models\Album;
use App\Models\Track;

class TrackSeeder extends CsvSeeder
{
    protected string $fileName = 'database/seeders/data/tracks.csv';

    protected string $model = Track::class;

    protected function getMapping(): array
    {
        return [
            'album_id' => 0,
            'title' => 1,
            'length' => 2,
            'order' => 3,
        ];
    }

    protected function specialValueMappings(): array
    {
        return [
            'length' => fn($value) => (new TimeToSeconds)($value),
            'album_id' => fn($value) => Album::where('title', $value)->first()->id,
        ];
    }
}
