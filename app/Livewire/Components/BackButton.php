<?php

namespace App\Livewire\Components;

use Livewire\Component;

class BackButton extends Component
{
    public string $route;
    public string $label;

    public function mount($route = null, $label = 'Regresar')
    {
        $this->route = $route ?? url()->previous(); // Usa la ruta o la anterior si no se pasa
        $this->label = $label;
    }
    public function render()
    {
        return view('livewire.components.back-button');
    }
}
