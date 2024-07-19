<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\AlbumResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AlbumCollection extends ResourceCollection
{
    public $collects = AlbumResource::class;
}
