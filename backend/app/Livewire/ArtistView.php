<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;

class ArtistView extends Component
{
    public Artist $artist;

    public function render()
    {
        return view('pages.artist-view');
    }
}
