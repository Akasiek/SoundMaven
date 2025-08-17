<?php

namespace App\Enums;

enum SearchTypeEnum: string
{
    case ALBUM = 'album';
    case ARTIST = 'artist';
    case TRACK = 'track';
}
