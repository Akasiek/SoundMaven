<?php

namespace App\Livewire;

use App\Models\Album;
use Illuminate\View\View;
use Livewire\Component;

class AlbumView extends Component
{
    public Album $album;

    public function mount(string $albumId): void
    {
        $this->album = Album::where(uuid_is_valid($albumId) ? 'id' : 'slug', $albumId)->firstOrFail();
    }

    public function render(): View
    {
        return view('pages.album-view')->title($this->album->title . ' - Album Page');
    }
}
