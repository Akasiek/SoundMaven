<?php

namespace App\Models;

use App\Models\Abstract\AbstractModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class AlbumTag extends AbstractModel
{
    use HasFactory, HasUuids, BlameableTrait;

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
