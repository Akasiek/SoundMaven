<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\AlbumTagResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AlbumTagCollection extends ResourceCollection
{
    public $collects = AlbumTagResource::class;
}
