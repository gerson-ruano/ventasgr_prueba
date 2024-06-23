<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Notification extends Component
{  
    public $message = '';
    public $type = 'success';
    public $visible = false;

    protected $listeners = ['showNotification', 'closeNotification'];

    public function showNotification($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
        $this->visible = true;

        $this->dispatch('notification-auto-hide');
        
    }

    public function closeNotification()
    {
        $this->visible = false;
    }
    
    public function render()
    {
        return view('livewire.components.notification');
    }
}