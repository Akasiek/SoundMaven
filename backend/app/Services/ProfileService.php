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
            $result = true;

            if ($dto->password) {
                $result = $user->update(['password' => bcrypt($dto->password)]);
            }

            if ($dto->avatar) {
                $user->detachAvatar();
                $user->attachAvatar($dto->avatar);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());

            return false;
        }
    }
}
