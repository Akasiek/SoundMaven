<?php

namespace App\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    /** @var array{name: string, route: string}[] */
    public array $links;

    public function mount(): void
    {
        $this->links = [
            ['name' => 'Home', 'route' => route('home')],
            ['name' => 'Artists', 'route' => route('artist.index')],
            ['name' => 'Contact', 'route' => route('home')],
        ];
    }
}
