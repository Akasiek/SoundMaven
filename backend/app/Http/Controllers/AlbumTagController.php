<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumTagRequest;
use App\Http\Resources\AlbumTagResource;
use App\Http\Resources\Collections\AlbumTagCollection;
use App\Models\AlbumTag;
use Spatie\QueryBuilder\QueryBuilder;

class AlbumTagController extends Controller
{
    public function index()
    {
        return new AlbumTagCollection(
            QueryBuilder::for(AlbumTag::class)
                ->withCount('albums')
                ->with(['albums'])
                // ->leftJoin('album_album_tag', 'album_tags.id', '=', 'album_album_tag.album_tag_id')
                // ->leftJoin('albums', 'album_album_tag.album_id', '=', 'albums.id')
                ->allowedFilters(['name', 'albums.id', 'albums.title'])
                ->allowedSorts(['name', 'albums_count'])
                ->paginate()
        );
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
