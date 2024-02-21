<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\AlbumReviewResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AlbumReviewCollection extends ResourceCollection
{
    public $collects = AlbumReviewResource::class;
}
