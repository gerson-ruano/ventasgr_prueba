<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component

{
    use WithFileUploads;
    use WithPagination;

    public function render()
    {
        $data = Category::all();
        
        return view('livewire.category.categories', ['categories' => $data])
        ->extends('layouts.app')
        ->section('content');
    }
}
