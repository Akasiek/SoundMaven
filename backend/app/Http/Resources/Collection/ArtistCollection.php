<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\ArtistResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArtistCollection extends ResourceCollection
{
    public $collects = ArtistResource::class;
}
