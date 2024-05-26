<?php

namespace App\Livewire;

use Livewire\Component;

class ReusableModal extends Component
{
    public $isOpen = false;
    public $title;
    public $content;

    protected $listeners = ['openModal', 'closeModal'];

    public function openModal($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function render()
    {
        return view('livewire.reusable-modal');
    }
}