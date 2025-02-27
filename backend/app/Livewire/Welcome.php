<?php

namespace App\Livewire;

use App\Models\Album;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Welcome')]
class Welcome extends Component
{
    /** @var Collection<Album> $albums */
    public Collection $albums;

    public function mount()
    {
        $this->albums = Album::limit(10)->get();
    }

    public function render()
    {
        return view('pages.welcome');
    }
}
