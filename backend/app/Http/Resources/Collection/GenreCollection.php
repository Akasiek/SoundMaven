<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\GenreResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GenreCollection extends ResourceCollection
{
    public $collects = GenreResource::class;
}
