<?php

namespace App\Enums;

enum AlbumTypeEnum: string
{
    case LP = 'LP';
    case EP = 'EP';
    case SINGLE = 'Single';
    case COMPILATION = 'Compilation';
    case LIVE = 'Live';
    case SOUNDTRACK = 'Soundtrack';
    case REMIX = 'Remix';
    case OTHER = 'Other';

    public static function getSortOrder(): array
    {
        return [
            self::LP->value => 1,
            self::EP->value => 2,
            self::SINGLE->value => 3,
            self::COMPILATION->value => 4,
            self::LIVE->value => 5,
            self::SOUNDTRACK->value => 6,
            self::REMIX->value => 7,
            self::OTHER->value => 8,
        ];
    }
}
