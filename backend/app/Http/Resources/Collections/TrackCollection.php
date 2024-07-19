<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\TrackResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TrackCollection extends ResourceCollection
{
    public $collects = TrackResource::class;
}
