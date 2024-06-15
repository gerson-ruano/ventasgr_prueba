<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Denomination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class Coins extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $type, $value, $componentName, $pageTitle, $selected_id, $image, $imageUrl, $search;

    public $isModalOpen = false;
    private $pagination = 5;

    protected $rules = [
        'type' => 'required|not_in:Elegir',
        'value' => 'required|unique:denominations'
    ];

    protected $messages = [
        'type.required' => 'El tipo es requerido',
        'type.not_in' => 'Elige un valor para el tipo distinto a Elegir',
        'value.required' => 'El valor es requerido',
        'value.unique' => 'Ya existe el valor'
    ];

    public function mount()
    {
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
        $this->type = null;
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }
    public function render()
    {
        $data = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.denominations.components', ['coins' => $data])
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

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->dispatch('noty-added', type: 'DENOMINACION', name: $denomination->type);
    }

    public function edit($id)
    {
        $record = Denomination::find($id, ['id','type','value','image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->imageUrl = $record->image ? Storage::url('denominations/' . $record->image) : null;
        $this->image = null;

        $this->openModal();
    }

    public function update()
    {
        // Actualización de reglas de validación para la edición
        $this->rules['value'] = "required|unique:denominations,value,{$this->selected_id}";

        // Validación
        $this->validate();

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);

            $imageName = $denomination->image;
            $denomination->image = $customFileName;
            $denomination->save();

            if($imageName !=null)
            {
                if(file_exists('storage/denominations' . $imageName))
                {
                    unlink('storage/denominations' . $imageName);
                }
            }
        }
        
        $this->dispatch('noty-updated', type:'DENOMINACIÓN', name: $denomination->type);
    }

    public function destroy($id)
    {
        $denomination = Denomination::find($id);

        if ($denomination) {
            $imageName = $denomination->image;
            $denomination->delete();

            if ($imageName != null) {
                if (file_exists(storage_path('app/public/denominations/' . $imageName))) {
                    unlink(storage_path('app/public/denominations/' . $imageName));
                }
            }

            // Restablecer UI y emitir evento
            $this->dispatch('noty-deleted', type: 'DENOMINATIÓN', name: $denomination->type);
        } else {
            // Manejo de caso donde la categoría no se encuentra
            $this->dispatch('noty-not-found', type: 'DENOMINATIÓN', name: $denomination->id);
        }
    }


    protected $listeners = [
        'deleteRow' => 'destroy' 
    ];

    public function resetUI()
    {
        $this->type = 'Elegir';
        $this->value = '';
        $this->image = null;
        $this->imageUrl = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}