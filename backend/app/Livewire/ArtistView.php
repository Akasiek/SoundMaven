<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;

class ArtistView extends Component
{
    public Artist $artist;

    public function mount(string $artistId): void
    {
        $this->artist = Artist::where(uuid_is_valid($artistId) ? 'id' : 'slug', $artistId)->firstOrFail();
    }

    public function render()
    {
        return view('pages.artist-view')->title($this->artist->name . ' - Artist Page');
    }
}
