<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlbumCollection extends ResourceCollection
{
    public $collects = AlbumResource::class;

}
