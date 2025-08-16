<?php

namespace App\Services;

use App\Helpers\TimeToSeconds;
use App\Models\Album;
use App\Models\Track;
use Exception;
use Illuminate\Validation\ValidationException;

class AlbumService
{
    public function create(array $data): Album
    {
        $album = Album::create($data);

        if (isset($data['cover_image'])) {
            $album->attachCoverImage($data['cover_image']);
        }

        return $album;
    }

    public function update(array $data, Album $model): Album
    {
        $requestHasCoverImage = isset($data['cover_image']);

        if ($requestHasCoverImage) {
            $model->detachCoverImage();
        }

        $model->update($data);

        if ($requestHasCoverImage) {
            $model->attachCoverImage($data['cover_image']);
        }

        return $model;
    }

    public function delete(Album $model): bool
    {
        return $model->delete();
    }

    public function updateTracks(array $data, Album $model): void
    {
        $tracks = collect($data['tracks'])->map(fn($track) => new Track([
            'title' => $track['title'],
            'order' => $track['order'],
            'length' => $this->getDurationInSeconds($track['duration']),
            'disc' => $track['disc'],
        ]));

        // Detach existing tracks and attach new ones
        $model->tracks()->delete();
        $model->tracks()->saveMany($tracks);
    }

    private function getDurationInSeconds(string $duration): int
    {
        // Possible values: 00:00:00, 00:00, 0:00, 00
        $regex = '/^(?:(\d{1,2}):)?(\d{1,2}):?(\d{1,2})?$/';
        if (!preg_match($regex, $duration)) {
            throw ValidationException::withMessages(
                ['tracks.*.duration' => __('Invalid duration format. Expected format is HH:MM or HH:MM:SS.')]
            );
        }

        try {
            return TimeToSeconds::convert($duration);
        } catch (Exception) {
            throw ValidationException::withMessages(
                ['tracks.*.duration' => __('Invalid duration format. Expected format is HH:MM or HH:MM:SS.')]
            );
        }
    }


}
