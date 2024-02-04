<?php

namespace App\Models;

use App\Traits\HasReviews;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Album extends Model
{
    use HasFactory, HasUuids, Sluggable, BlameableTrait, HasReviews;

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
}
