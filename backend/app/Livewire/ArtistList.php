<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;
use Livewire\WithPagination;

class ArtistList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('pages.artist-list', [
            'artists' => Artist::paginate(24),
        ]);
    }
}
