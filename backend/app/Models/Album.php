<?php

namespace App\Models;

use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Album extends Model
{
    use SoftDeletes, HasFactory, HasUuids, Sluggable, BlameableTrait;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'type',
        'artist_id',
    ];

    protected $attributes = [
        'type' => 'LP',
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

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(AlbumTag::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating');
    }
}
