<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class Categories extends Component

{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $imageUrl, $selected_id, $pageTitle, $componentName;
    public $isModalOpen = false;
    private $pagination = 5;

    protected $rules = [
        'name' => 'required|unique:categories|min:3',
        'image' => 'nullable|image|max:1024',
    ];

    protected $messages = [
        'name.required' => 'Nombre de la categoría es requerido',
        'name.unique' => 'Ya existe el nombre de la categoría',
        'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres',
        'image.image' => 'El archivo debe ser una imagen',
        'image.max' => 'La imagen no debe superar los 1024 kilobytes',
    ];

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
        $query = Category::orderBy('id', 'desc');

    if ($this->search) {
        $query->where('name', 'like', '%' . $this->search . '%');
    }

    $categories = $query->paginate($this->pagination);

    return view('livewire.category.components', compact('categories'))
        ->extends('layouts.app')
        ->section('content');
    }

    
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    #[On('noty-updated')]
    #[On('noty-added')]
    #[On('noty-deleted')]
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetUI();
        $this->resetValidation();
    }

    public function store()
    {
        // Validación de reglas
        $this->validate();

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
    
        $this->dispatch('noty-added', type: 'CATEGORÍA', name: $category->name);
    }

    public function edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->imageUrl = $record->image ? Storage::url('categories/' . $record->image) : null;
        $this->image = null;

        $this->openModal();
    }

    public function update()
    {
        // Actualización de reglas de validación para la edición
        $this->rules['name'] = "required|min:3|unique:categories,name,{$this->selected_id}";

        // Validación
        $this->validate();

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
        $this->dispatch('noty-updated', type: 'CATEGORÍA', name: $category->name);
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
            $this->dispatch('noty-deleted', type: 'CATEGORÍA', name: $category->name);
        } else {
            // Manejo de caso donde la categoría no se encuentra
            $this->dispatch('noty-not-found', type: 'CATEGORÍA', name: $category->id);
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'searchUpdated' => 'updateSearch',
    ];

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->imageUrl = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function updateSearch($search)
    {
        $this->search = $search;
    }
    
}