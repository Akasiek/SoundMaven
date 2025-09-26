<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController
{
    public function show(User $user): Response
    {
        $user->loadCount(['albumReviews']);

        return Inertia::render('user/Show', [
            'user' => new UserResource($user),
        ]);
    }
}
