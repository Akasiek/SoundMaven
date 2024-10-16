<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use Exception;

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
            'cover_image' => 4,
        ];
    }

    protected function specialValueMappings(): array
    {
        return [
            'artist_id' => fn($value) => Artist::where('name', $value)->first()->id,
        ];
    }

    protected function seedFromCsv(): void
    {
        $data = $this->mapCsvData();
        $data = $this->mapSpecialValues($data);

        foreach ($data as $row) {
            $coverImage = $row['cover_image'];
            $rowWithoutCover = array_filter($row, fn($key) => $key !== 'cover_image', ARRAY_FILTER_USE_KEY);

            $album = $this->model::updateOrCreate($rowWithoutCover);

            if (!$album) {
                throw new Exception('Cannot create seeded model');
            }

            if ($coverImage) {
                $album->attachCoverImage(base_path("database/seeders/data/cover_images/$coverImage"));
            }
        }

    }
}
