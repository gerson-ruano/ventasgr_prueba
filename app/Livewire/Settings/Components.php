<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Setting;

class Components extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->settings = Setting::pluck('value', 'key')->toArray();
    }

    public function updatedSettings($value, $key)
    {
        Setting::set($key, $value);
        //session()->flash('message', 'Configuración guardada.');
        $this->dispatch('showNotification', 'act ' . $key . ' actualizado exitosamente', 'info');
    }

    public function render()
    {
        $meta = Setting::all();
        return view('livewire.settings.components', compact('meta'))
            ->extends('layouts.app')
            ->section('content');
    }

}
