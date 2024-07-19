<?php

namespace App\Models;

use App\Models\Abstract\AbstractModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Artist extends AbstractModel
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait;

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
