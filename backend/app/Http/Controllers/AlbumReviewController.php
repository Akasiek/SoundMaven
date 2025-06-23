<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumReviewRequest;
use App\Http\Requests\Update\UpdateAlbumReviewRequest;
use App\Http\Resources\AlbumReviewResource;
use App\Http\Resources\Collections\AlbumReviewCollection;
use App\Models\AlbumReview;
use App\Services\AlbumReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class AlbumReviewController extends Controller
{
    private AlbumReviewService $service;

    public function __construct(AlbumReviewService $service)
    {
        $this->service = $service;
    }

    public function index(): AlbumReviewCollection
    {
        return new AlbumReviewCollection(
            QueryBuilder::for(AlbumReview::class)
                ->allowedIncludes(['album', 'creator'])
                ->allowedFilters(['rating', 'album_id', 'created_by', 'album.title', 'creator.name'])
                ->allowedSorts(['rating', 'created_at'])
                ->paginate(request('perPage'))
        );
    }

    public function show(AlbumReview $albumReview): AlbumReviewResource
    {
        return new AlbumReviewResource($albumReview->loadMissing(['album', 'creator']));
    }

    public function store(StoreAlbumReviewRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('albums.show', $request->album_id)
            ->with('success', 'Album review created successfully.');
    }

    public function update(UpdateAlbumReviewRequest $request, AlbumReview $albumReview): AlbumReviewResource
    {
        return new AlbumReviewResource(
            $this->service->update($request->validated(), $albumReview)->loadMissing(['album', 'creator'])
        );
    }

    public function destroy(AlbumReview $albumReview): Response
    {
        $this->service->delete($albumReview);

        return response()->noContent();
    }
}
