<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Searchbox extends Component
{
    public $search;
    public $placeholder;

    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', $this->search);
    }
    public function mount()
    {
        // Si no se pasa un valor para $placeholder, establece uno por defecto
        $this->placeholder = $this->placeholder ?? 'Buscar';
    }
    public function render()
    {
        return view('livewire.components.searchbox');
    }
}
