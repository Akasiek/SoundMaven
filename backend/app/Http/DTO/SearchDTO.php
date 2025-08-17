<?php

namespace App\Http\DTO;

use App\Http\Requests\SearchRequest;

readonly class SearchDTO
{
    public function __construct(public string $query, public ?string $type = null) { }

    public static function fromRequest(SearchRequest $request): self
    {
        return new self(query: $request->input('query'), type: $request->input('type'));
    }
}
