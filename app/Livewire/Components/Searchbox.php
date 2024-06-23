<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Searchbox extends Component
{
    public $search;

    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', $this->search);
    }
    public function render()
    {
        return view('livewire.components.searchbox');
    }
}
