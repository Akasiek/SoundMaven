<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Album extends Model
{
    use HasFactory, HasUuids, Sluggable, BlameableTrait;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'artist_id',
    ];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
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
