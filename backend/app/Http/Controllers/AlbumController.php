<?php

namespace App\Http\Controllers;

use App\Enums\AlbumTypes;
use App\Http\Requests\Store\StoreAlbumRequest;
use App\Http\Requests\Update\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumReviewResource;
use App\Http\Resources\Collections\AlbumReviewCollection;
use App\Http\Resources\Collections\AlbumTagCollection;
use App\Http\Resources\Collections\GenreCollection;
use App\Http\Resources\Collections\TrackCollection;
use App\Models\Album;
use App\Models\AlbumTag;
use App\Models\Genre;
use App\Services\AlbumService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AlbumController extends Controller
{
    private AlbumService $service;

    public function __construct(AlbumService $service)
    {
        $this->service = $service;
    }

    public function index(): \Inertia\Response
    {
        $albums = AlbumResource::collection(
            Album::with(['artist'])
                ->paginate(request('perPage', 24))
        );

        return Inertia::render('album/List', [
            'albums' => $albums,
        ]);
    }

    public function show(Album $album): \Inertia\Response
    {
        $currentUserReview = $album->reviews()->where('created_by', auth()->id())->first();
        $latestRatings = $album->reviews()->with('creator')
            ->whereNull('body')
            ->whereNot('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)->get();
        $latestReviews = $album->reviews()->with('creator')
            ->whereNotNull('body')
            ->whereNot('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        return Inertia::render('album/Show', [
            'album' => new AlbumResource($album->loadMissing(['artist', 'tracks', 'genres'])->loadCount(['reviews'])),
            'currentUserReview' => $currentUserReview ? new AlbumReviewResource($currentUserReview) : null,
            'latestRatings' => AlbumReviewResource::collection($latestRatings),
            'latestReviews' => AlbumReviewResource::collection($latestReviews),
        ]);
    }

    public function displayCreateForm(): \Inertia\Response
    {
        return Inertia::render('album/Create', [
            'types' => AlbumTypes::cases(),
        ]);
    }

    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $album = $this->service->create($request->validated());

        return redirect()->route('albums.show', $album->slug)
            ->with('success', __('Album created successfully.'));
    }

    public function displayUpdateForm(Album $album): \Inertia\Response
    {
        return Inertia::render('album/Update', [
            'album' => new AlbumResource($album->loadMissing(['artist', 'tracks', 'genres'])),
            'types' => AlbumTypes::cases(),
        ]);
    }

    public function update(UpdateAlbumRequest $request, string $albumParam): AlbumResource
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();

        return new AlbumResource(
            $this->service->update($request->validated(), $album)->loadMissing(['artist', 'tracks', 'genres'])
        );
    }

    public function destroy(Album $album): Response
    {
        $this->service->delete($album);

        return response()->noContent();
    }

    public function showTracks(string $albumParam): TrackCollection
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();

        return new TrackCollection($album->tracks);
    }

    public function showReviews(string $albumParam): AlbumReviewCollection
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();

        return new AlbumReviewCollection($album->reviews);
    }

    public function showGenres(string $albumParam): GenreCollection
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();

        return new GenreCollection($album->genres);
    }

    public function attachGenre(string $albumParam, string $genreParam): Response
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();
        $genre = Genre::whereSlugOrId($genreParam)->firstOrFail();

        $album->genres()->attach($genre);

        return response()->noContent(HttpResponse::HTTP_CREATED);
    }

    public function detachGenre(string $albumParam, string $genreParam): Response
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();
        $genre = Genre::whereSlugOrId($genreParam)->firstOrFail();

        $album->genres()->detach($genre);

        return response()->noContent();
    }

    public function showTags(string $albumParam): AlbumTagCollection
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();

        return new AlbumTagCollection($album->tags);
    }

    public function attachTag(string $albumParam, string $tagParam): Response
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();
        $tag = AlbumTag::whereSlugOrId($tagParam)->firstOrFail();

        $album->tags()->attach($tag);

        return response()->noContent(HttpResponse::HTTP_CREATED);
    }

    public function detachTag(string $albumParam, string $tagParam): Response
    {
        $album = Album::whereSlugOrId($albumParam)->firstOrFail();
        $tag = AlbumTag::whereSlugOrId($tagParam)->firstOrFail();

        $album->tags()->detach($tag);

        return response()->noContent();
    }
}
