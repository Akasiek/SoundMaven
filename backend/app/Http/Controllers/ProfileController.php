<?php

namespace App\Http\Controllers;

use App\Http\DTO\UpdateProfileDTO;
use App\Http\Requests\Update\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfileService;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController
{
    public function __construct(private readonly ProfileService $service = new ProfileService) {}

    public function displayUpdateForm(): Response
    {
        return Inertia::render('profile/Edit', [
            'user' => UserResource::make(auth()->user()),
            'messages' => session()->only(['success', 'error']),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $res = $this->service->update(UpdateProfileDTO::fromRequest($request));

        return redirect()
            ->back()
            ->with(
                $res ? 'success' : 'error',
                $res ? __('Profile updated successfully.') : __('An error occurred while updating the profile.')
            );
    }

    public function destroy()
    {
        // TODO: Destroy profile logic here
    }
}
