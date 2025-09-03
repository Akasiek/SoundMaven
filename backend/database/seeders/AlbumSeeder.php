<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use Exception;

class AlbumSeeder extends CsvSeeder
{
    protected string $fileName = 'database/seeders/data/albums.csv';
    protected string $model = Album::class;

    public function run(bool $seedImages = true): void
    {
        $this->seedFromCsv();
    }

    protected function getMapping(): array
    {
        return [
            'artist_id' => 0,
            'title' => 1,
            'release_date' => 2,
            'type' => 3,
            'cover_image' => 4,
            'genres' => 5,
        ];
    }

    protected function specialValueMappings(): array
    {
        return [
            'artist_id' => fn($value) => Artist::where('name', $value)->first()->id,
            'genres' => fn($value) => $value ? array_map(
                fn($genre) => Genre::where('name', $genre)->first()->id,
                explode('|', $value)
            ) : [],
        ];
    }

    protected function seedFromCsv(bool $seedImages = true): void
    {
        $data = $this->mapCsvData();
        $data = $this->mapSpecialValues($data);

        foreach ($data as $row) {
            $coverImage = $row['cover_image'];
            $genres = $row['genres'];
            $filteredRow = array_filter($row, fn($key) => !in_array($key, ['cover_image', 'genres']), ARRAY_FILTER_USE_KEY);

            $album = $this->model::updateOrCreate($filteredRow);

            if (!$album) {
                throw new Exception('Cannot create seeded model');
            }

            if ($seedImages && $coverImage) {
                $album->detachCoverImage();
                $album->attachCoverImage(base_path("database/seeders/data/cover_images/$coverImage"));
            }

            $album->genres()->sync($genres);
        }
    }
}
