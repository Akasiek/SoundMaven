<?php

namespace App\Livewire;

use App\Models\Artist;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ArtistList extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('pages.artist-list')->with([
            'artists' => Artist::paginate(24),
        ])->title('Artists');
    }
}
