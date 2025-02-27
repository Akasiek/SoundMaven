<?php

namespace App\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    /** @var array{name: string, route: string}[] $links */
    public array $links;

    public function mount(): void
    {
        $this->links = [
            ['name' => 'Home', 'route' => route('home')],
            ['name' => 'Artists', 'route' => route('home')],
            ['name' => 'Contact', 'route' => route('home')],
        ];
    }
}
