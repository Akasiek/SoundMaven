<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property string name
 * @property string description
 * @property string type
 */
class Artist extends Model
{
    use HasFactory, HasUuids, Sluggable, BlameableTrait;

    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

}
