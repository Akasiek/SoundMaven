<?php

namespace App\Services;

use App\Http\DTO\UpdateProfileDTO;
use Exception;
use Log;

class ProfileService
{
    public function update(UpdateProfileDTO $dto): bool
    {
        try {
            $user = auth()->user();

            $updates = array_filter([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => $dto->password ? bcrypt($dto->password) : null,
                'favorite_artist_id' => $dto->favorite_artist_id,
            ]);

            // Also filter out default values to avoid unnecessary updates
            $updates = array_filter($updates, function($value, $key) use ($user) {
                if ($key === 'password') {
                    return true; // Always update password if provided
                }

                return $value !== $user->$key;
            }, ARRAY_FILTER_USE_BOTH);

            if (!empty($updates)) {
                $user->update($updates);
            }

            if ($dto->avatar) {
                $user->detachAvatar();
                $user->attachAvatar($dto->avatar);
            }

            return true;
        } catch (Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());

            return false;
        }
    }
}
