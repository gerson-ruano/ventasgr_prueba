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

    public function editCategory($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->openModal();
        $this->dispatch('show-modal');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetUI();
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

        // Restablecer UI y emitir eventos
        $this->resetUI();
        $this->closeModal();
        $this->dispatch('category-added', ['name' => $this->name]);
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
        $this->resetUI();
        $this->closeModal();
        $this->dispatch('category-updated', 'Categoria Actualizada');

    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function Destroy(Category $category)
    {
        // Eliminar la categoría y su imagen asociada si existe
        $imageName = $category->image;
        $category->delete();

        if ($imageName != null) {
            unlink('storage/categories/' . $imageName);
        }

        // Restablecer UI y emitir evento
        $this->resetUI();
        $this->dispatch('category-deleted', ['name' => $category->name]);
    }
    
}