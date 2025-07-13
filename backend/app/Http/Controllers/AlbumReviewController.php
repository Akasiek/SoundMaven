<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumReviewRequest;
use App\Models\AlbumReview;
use App\Services\AlbumReviewService;
use Illuminate\Http\RedirectResponse;

class AlbumReviewController extends Controller
{
    private AlbumReviewService $service;

    public function __construct(AlbumReviewService $service)
    {
        $this->service = $service;
    }

    public function store(StoreAlbumReviewRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->back()
            ->with('success', 'Album review created successfully.');
    }

    public function destroy(AlbumReview $albumReview): RedirectResponse
    {
        $this->service->delete($albumReview);

        return redirect()->back()
            ->with('success', 'Album review deleted successfully.');
    }
}
