<?php

namespace App\Http\Controllers;

use App\Http\DTO\SearchDTO;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Collections\SearchResultCollection;
use App\Services\SearchService;

class SearchController extends Controller
{
    public function __construct(private readonly SearchService $service = new SearchService()) { }

    public function search(SearchRequest $request): SearchResultCollection
    {
        return $this->service->search(SearchDTO::fromRequest($request));
    }
}
