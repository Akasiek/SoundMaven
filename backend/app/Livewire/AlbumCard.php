<?php

namespace App\Livewire;

use App\Models\Album;
use Livewire\Component;

class AlbumCard extends Component
{
    public Album $album;
    public bool $showArtist = false;
}
