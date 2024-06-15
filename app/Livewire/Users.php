<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;


class Users extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $profile;
    public $pageTitle, $componentName, $search, $perfilSeleccionado;

    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
    }
    public function render()
    {
        
    $data = User::orderBy('id', 'desc')->paginate($this->pagination);
    return view('livewire.users.components', ['users' => $data])
        ->extends('layouts.app')
        ->section('content');
    }
}