<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreGenreRequest;
use App\Http\Requests\Update\UpdateGenreRequest;
use App\Http\Resources\Collections\GenreCollection;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Services\GenreService;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class GenreController extends Controller
{
    private GenreService $service;

    public function __construct(GenreService $service)
    {
        $this->service = $service;
    }

    public function index(): GenreCollection
    {
        return new GenreCollection(
            QueryBuilder::for(Genre::class)
                ->with(['albums'])
                ->withCount(['albums'])
                ->allowedFilters(['name', 'albums.title', 'albums.artist.name'])
                ->allowedSorts(['name', 'albums_count', 'created_at', 'updated_at'])
                ->paginate()
        );
    }

    public function show(string $genreParam): GenreResource
    {
        $genre = Genre::whereSlugOrId($genreParam)->firstOrFail();

        return new GenreResource($genre->loadMissing(['albums']));
    }

    public function store(StoreGenreRequest $request): GenreResource
    {
        return new GenreResource(
            $this->service->create($request->validated())->loadMissing(['albums'])
        );
    }

    public function update(UpdateGenreRequest $request, string $genreParam): GenreResource
    {
        $genre = Genre::whereSlugOrId($genreParam)->firstOrFail();

        return new GenreResource(
            $this->service->update($request->validated(), $genre)->loadMissing(['albums'])
        );
    }

    public function destroy(Genre $genre): Response
    {
        $this->service->delete($genre);

        return response()->noContent();
    }

    public function showAlbums(string $genreParam): GenreCollection
    {
        $genre = Genre::whereSlugOrId($genreParam)->firstOrFail();

        return new GenreCollection($genre->albums);
    }
}
