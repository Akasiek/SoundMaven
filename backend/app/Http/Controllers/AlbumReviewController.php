<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumReviewRequest;
use App\Http\Requests\Update\UpdateAlbumReviewRequest;
use App\Http\Resources\AlbumReviewResource;
use App\Http\Resources\Collection\AlbumReviewCollection;
use App\Models\AlbumReview;
use App\Services\AlbumReviewService;
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
                ->allowedFilters([
                    'creator.name',
                    'album.title',
                ])
                ->get()
        );
    }

    public function show(AlbumReview $albumReview): AlbumReviewResource
    {
        return new AlbumReviewResource($albumReview->loadMissing(['album', 'creator']));
    }

    public function store(StoreAlbumReviewRequest $request): AlbumReviewResource
    {
        return new AlbumReviewResource(
            $this->service->create($request->validated())->loadMissing(['album', 'creator'])
        );
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
