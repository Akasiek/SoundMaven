<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Genre extends Model
{
    use SoftDeletes, HasFactory, HasUuids, Sluggable, BlameableTrait;

    protected $fillable = [
        'name',
        'description',
    ];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }

    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Genre::class, 'parent_id');
    }
}
