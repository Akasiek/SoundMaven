<?php

namespace App\Models\Abstract;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    use Sluggable;

    public static function whereSlugOrId(string $param)
    {
        return static::where(uuid_is_valid($param) ? 'id' : 'slug', $param);
    }

    abstract public function sluggable(): array;
}
