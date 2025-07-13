<?php

namespace App\Enums;

enum AlbumTypes: string
{
    case LP = 'LP';
    case EP = 'EP';
    case SINGLE = 'Single';
    case COMPILATION = 'Compilation';
    case LIVE = 'Live';
    case SOUNDTRACK = 'Soundtrack';
    case REMIX = 'Remix';
    case OTHER = 'Other';
}
