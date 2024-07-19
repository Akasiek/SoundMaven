<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumTagRequest;
use App\Http\Resources\AlbumTagResource;
use App\Models\AlbumTag;

class AlbumTagController extends Controller
{
    public function index()
    {
        return AlbumTagResource::collection(AlbumTag::all()->loadCount('albums'));
    }

    public function show(AlbumTag $albumTag)
    {
        return new AlbumTagResource($albumTag->load('albums')->loadCount('albums'));
    }

    public function store(AlbumTagRequest $request)
    {
        return new AlbumTagResource(AlbumTag::create($request->validated()));
    }

    public function update(AlbumTagRequest $request, AlbumTag $albumTag)
    {
        $albumTag->update($request->validated());

        return new AlbumTagResource($albumTag);
    }

    public function destroy(AlbumTag $albumTag)
    {
        $albumTag->albums()->detach();
        $albumTag->delete();

        return response()->noContent();
    }
}
