<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Categories extends Component

{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    public $isModalOpen = false;
    private $pagination = 5;


    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function render()
    {
        $data = Category::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.category.categories', ['categories' => $data])
        ->extends('layouts.app')
        ->section('content'); 
    }

    
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    #[On('category-updated')]
    //#[On('category-added')]
    #[On('category-deleted')]
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetUI();
        $this->resetValidation();
    }

    public function storeCategory()
    {
        // Validación de reglas
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        // Mensajes de validación personalizados
        $messages = [
            'name.required' => 'Nombre de la categoría es requerido',
            'name.unique' => 'Ya existe el nombre de la categoría',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres'
        ];

        // Validación
        $this->validate($rules, $messages);

        // Crear la categoría
        $category = Category::create([
            'name' => $this->name
        ]);

        // Manejo de la imagen
        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }
        $this->closeModal();
        $this->dispatch('category-added', name: $category->name);
    }

    public function editCategory($id)
    {
        //dd($id);
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->openModal();
    }

    public function updateCategory()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Nombre de Categoria Requerido',
            'name.min' => 'El nombre de la categoria debe tener al menos 3 caracteres',
            'name.unique' => 'El nombre de la categoria ya existe'
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);

            $imageName = $category->image;
            $category->image = $customFileName;
            $category->save();

            if($imageName !=null)
            {
                if(file_exists('storage/categories' . $imageName))
                {
                    unlink('storage/categories' . $imageName);
                }
            }
        }

        $this->closeModal();
        $this->dispatch('category-updated', name: $category->name);

    }

    protected $listeners = [
        'deleteRow' => 'destroy' 
    ];

    #[On('category-added')]
    public function refresh()
    {
        $this->render();
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $imageName = $category->image;
            $category->delete();

            if ($imageName != null) {
                if (file_exists(storage_path('app/public/categories/' . $imageName))) {
                    unlink(storage_path('app/public/categories/' . $imageName));
                }
            }

            // Restablecer UI y emitir evento
            $this->dispatch('category-deleted', name: $category->name);
        } else {
            // Manejo de caso donde la categoría no se encuentra
            $this->dispatch('category-not-found', name: $category->id);
        }
    }
    
}