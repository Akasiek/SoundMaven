<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class AlbumTag extends Model
{
    use HasFactory, HasUuids, Sluggable, BlameableTrait;

    protected $fillable = [
        'name',
    ];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }

    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class);
    }
}
