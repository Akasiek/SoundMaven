<?php

namespace App\Livewire;

use Livewire\Component;

class SideNavigation extends Component
{
    public string|null $searchQuery = null;

    public function search()
    {
        if (empty($this->searchQuery)) {
            return;
        }
        // Search logic TODO
        dd($this->searchQuery);
    }
}
