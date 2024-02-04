<?php

namespace App\Models;

use App\Models\Abstract\Review;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumReview extends Review
{
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
