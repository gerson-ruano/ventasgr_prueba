<?php

namespace App\Livewire\Components;
use Illuminate\Http\Request;

use Livewire\Component;

class Searchbox extends Component
{
    /*public $search;
    public $placeholder;
    public $model;

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
    }*/

    public $search;
    public $placeholder;
    public $model;
    public $emitOnEnter; // Nueva propiedad

    public function updatedSearch()
    {
        $this->dispatch('searchUpdated', $this->search);
    }

    public function scanCode()
    {
        // Solo se llama si emitOnEnter está definido
        $barcode = trim($this->search);
        $this->dispatch($this->emitOnEnter, ['barcode' => $barcode]);
        $this->search = ''; // Limpiar input
    }

    public function mount()
    {
        $this->placeholder = $this->placeholder ?? 'Buscar';
    }

    public function render()
    {
        return view('livewire.components.searchbox');
    }
}
