<?php

namespace App\Services;

use App\Http\Resources\AlbumResource;
use App\Http\Resources\UserResource;
use App\Models\Album;
use App\Models\User;

class UserService
{
    public function getShowProps(User $user): array
    {
        $userResource = UserResource::make($user->loadCount(['albumReviews']));

        $latestRatings = AlbumResource::collection(
            Album::with(['artist'])
                ->rightJoin('album_reviews', 'albums.id', '=', 'album_reviews.album_id')
                ->where('album_reviews.created_by', $user->id)
                ->orderBy('album_reviews.created_at', 'desc')
                ->addSelect(['albums.*', 'album_reviews.rating as review_rating', 'album_reviews.created_at as review_date'])
                ->limit(24)
                ->get()
        );

        $latestReviews = AlbumResource::collection(
            Album::with(['artist'])
                ->rightJoin('album_reviews', 'albums.id', '=', 'album_reviews.album_id')
                ->where('album_reviews.created_by', $user->id)
                ->orderBy('album_reviews.created_at', 'desc')
                ->addSelect([
                    'albums.*',
                    'album_reviews.body as review_body',
                    'album_reviews.rating as review_rating',
                    'album_reviews.created_at as review_date',
                ])
                ->whereNotNull('album_reviews.body')
                ->limit(24)
                ->get()
        );

        // Group ratings by 10 from 0 to 100 and count the number of ratings in each group
        $ratingsForDistributionChart = Album::with(['artist'])
            ->rightJoin('album_reviews', 'albums.id', '=', 'album_reviews.album_id')
            ->where('album_reviews.created_by', $user->id)
            ->orderBy('album_reviews.created_at')
            ->addSelect(['albums.*', 'album_reviews.rating as rating'])
            ->get()
            ->groupBy(fn($item) => floor($item->rating / 10) * 10)
            ->map(fn($group) => [
                'rating' => $group->first()->rating - ($group->first()->rating % 10),
                'count' => $group->count(),
            ])
            ->sortBy('rating')
            ->values();

        return [
            'user' => $userResource,
            'latestRatings' => $latestRatings,
            'latestReviews' => $latestReviews,
            'ratingsForDistributionChart' => $ratingsForDistributionChart,
        ];
    }
}
