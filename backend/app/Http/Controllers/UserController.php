<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;

class UserController
{
    public function __construct(
        private readonly UserService $service
    ) {}

    public function show(User $user): Response
    {
        return Inertia::render('user/Show', $this->service->getShowProps($user));
    }
}
