<?php

namespace App\Http\Controllers;

use App\Http\Resources\AlbumResource;
use App\Http\Resources\UserResource;
use App\Models\Album;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController
{
    public function show(User $user): Response
    {
        return Inertia::render('user/Show', [
            'user' => UserResource::make($user->loadCount(['albumReviews'])),
            'latestRatings' => AlbumResource::collection(
                Album::with(['artist'])
                    ->rightJoin('album_reviews', 'albums.id', '=', 'album_reviews.album_id')
                    ->where('album_reviews.created_by', $user->id)
                    ->orderBy('album_reviews.created_at', 'desc')
                    ->addSelect(['albums.*', 'album_reviews.rating as rating'])
                    ->limit(24)
                    ->get()
            ),
            'latestReviews' => AlbumResource::collection(
                Album::with(['artist'])
                    ->rightJoin('album_reviews', 'albums.id', '=', 'album_reviews.album_id')
                    ->where('album_reviews.created_by', $user->id)
                    ->orderBy('album_reviews.created_at', 'desc')
                    ->addSelect(['albums.*', 'album_reviews.rating as rating', 'album_reviews.body as body'])
                    ->whereNotNull('album_reviews.body')
                    ->limit(24)
                    ->get()
            ),
        ]);
    }
}
