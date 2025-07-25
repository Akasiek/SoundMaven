<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMIN = 'admin';
    case MAINTAINER = 'maintainer';
    case USER = 'user';

    public static function values(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
