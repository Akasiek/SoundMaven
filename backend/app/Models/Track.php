<?php

namespace App\Models;

use App\Helpers\SecondsToTime;
use App\Models\Abstract\AbstractModel;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Track extends AbstractModel
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait;

    protected $fillable = [
        'title',
        'length',
        'order',
        'album_id',
    ];

    public function sluggable(): array
    {
        return ['slug' => [
            'source' => 'title',
            'method' => static function (string $string, string $separator): string {
                return (new Slugify(['separator' => $separator]))->slugify($string) ?: 'untitled';
            }
        ]];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function scopeOrderedAlbum(Builder $query, string $albumId): Builder
    {
        return $query->orderBy('order')->where('album_id', $albumId);
    }

    public function lengthInMinutes(): string
    {
        $converter = new SecondsToTime;

        return $converter($this->length);
    }
}
