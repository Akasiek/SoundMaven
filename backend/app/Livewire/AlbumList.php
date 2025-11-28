<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class AlbumList extends Component
{
    public Collection $albums;

    public bool $showArtist = true;
}
