<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Company;

class Companies extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $address, $email, $phone, $nit, $image, $search, $imageUrl, $selected_id, $pageTitle, $componentName;
    public $isModalOpen = false;
    private $pagination = 10;

    protected function rules()
    {

        $rules = [
            'name' => 'required|min:3|unique:companies,name,' . $this->selected_id,
            'email' => 'required|email|unique:companies,email,' . $this->selected_id,
            'phone' => 'max:8',
            'nit' => 'max:7',
            'address' => 'nullable|max:255',
            'image' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,svg',
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre de la compañia',
            'name.min' => 'El nombre de la compañia debe tener al menos 3 caracteres',
            'name.unique' => 'El nombre de la compañia ya existe en el sistema',
            'email.required' => 'Ingresa un correo',
            'email.email' => 'Ingresa un correo valido',
            'phone.min' => 'Ingrese un numero valido',
            'phone.max' => 'El numero telefonico debe tener 8 digitos',
            'email.unique' => 'El email ya existe en el sistema',
            'nit.min' => 'Ingrese un numero valido',
            'nit.max' => 'El NIT debe tener un maximo de 7 caracteres',
            'address.max' => 'La dirección no debe superar los 150 caracteres',
            'image.image' => 'El archivo debe ser una imagen',
            'image.max' => 'La imagen no debe superar los 1024 kilobytes',
            'image.required' => 'La imagen es requerida para la compañia',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, svg',

        ];
        return $rules;
    }


    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Compañías';
    }


    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function render()
    {
        $query = Company::orderBy('id', 'desc');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $companies = $query->paginate($this->pagination);

        return view('livewire.companies.components', compact('companies'))
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
        try {
            // Validación de reglas
            $this->validate();

            $this->authorize('companies.create', Category::class);
            // Crear la categoría
            $company = Company::create([
                'name' => $this->name,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'nit' => $this->nit
            ]);

            // Manejo de la imagen
            if ($this->image) {
                $customFileName = uniqid() . '.' . $this->image->extension();
                $this->image->storeAs('public/companies', $customFileName);
                $company->image = $customFileName;
                $company->save();
            }

            $this->dispatch('noty-added', type: 'COMPAÑIA', name: $company->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'CREAR');
        }
    }

    public function edit($id)
    {
        $record = Company::find($id, ['id', 'name', 'address', 'email', 'phone', 'nit', 'image']);
        $this->name = $record->name;
        $this->address = $record->address;
        $this->email = $record->email;
        $this->phone = $record->phone;
        $this->nit = $record->nit;
        $this->selected_id = $record->id;
        $this->imageUrl = $record->image ? Storage::url('companies/' . $record->image) : null;
        $this->image = null;

        $this->openModal();
    }

    public function update()
    {
        try {

            // Validación
            $this->validate();
            $this->authorize('companies.update', $this->selected_id);
            $company = Company::find($this->selected_id);
            $company->update([
                'name' => $this->name,
                'address' => $this->address,
                'email' => $this->email,
                'phone' => $this->phone,
                'nit' => $this->nit
            ]);

            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/companies', $customFileName);

                $imageName = $company->image;
                $company->image = $customFileName;
                $company->save();

                if ($imageName != null) {
                    if (file_exists('storage/companies' . $imageName)) {
                        unlink('storage/companies' . $imageName);
                    }
                }
            }
            $this->dispatch('noty-updated', type: 'COMPAÑIA', name: $company->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ACTUALIZAR');
        }
    }

    public function destroy($id)
    {
        try {
            $company = Company::find($id);
            $this->authorize('companies.delete', $company);

            if ($company) {
                $imageName = $company->image;
                $company->delete();

                if ($imageName != null) {
                    if (file_exists(storage_path('app/public/companies/' . $imageName))) {
                        unlink(storage_path('app/public/companies/' . $imageName));
                    }
                }

                // Restablecer UI y emitir evento
                $this->dispatch('noty-deleted', type: 'COMPAÑIA', name: $company->name);
            } else {
                // Manejo de caso donde la categoría no se encuentra
                $this->dispatch('noty-not-found', type: 'COMPAÑIAS', name: $company->id);
            }
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'COMPAÑIAS', permission: 'ELIMINAR');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'searchUpdated' => 'updateSearch',
    ];

    public function resetUI()
    {
        $this->name = '';
        $this->address = '';
        $this->email = '';
        $this->phone = '';
        $this->nit = '';
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
