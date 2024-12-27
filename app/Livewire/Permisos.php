<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class Permisos extends Component
{

    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    public $isModalOpen = false;
    private $pagination = 10;

    protected $rules = [
        'permissionName' => 'required|min:3|unique:permissions,name'
    ];

    protected $messages = [
        'permissionName.required' => 'Él nombre del permiso es requerido',
        'permissionName.unique' => 'El permiso ya existe',
        'permissionName.min' => 'El nombre del permiso debe tener como minimo 2 caracteres'
    ];

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        $query = Permission::orderBy('id', 'desc');

        if (strlen($this->search) > 0) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $data = $query->paginate($this->pagination);

        return view('livewire.permisos.components', ['permisos' => $data])
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
            $this->authorize('create', Permission::class);

            Permission::create([
                'name' => $this->permissionName
            ]);

            $this->dispatch('noty-added', type: 'PERMISO', name: $this->permissionName);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'CREAR');
        }
    }

    public function edit(Permission $permiso)
    {
        //$role = Role::find($id);
        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;

        $this->openModal();
    }

    public function update()
    {
        try {
            // Actualización de reglas de validación para la edición
            $this->rules['permissionName'] = "required|min:3|unique:permissions,name, {$this->selected_id}";

            // Validación
            $this->validate();
            $this->authorize('update', $this->selected_id);

            $permiso = Permission::find($this->selected_id);
            $permiso->name = $this->permissionName;
            $permiso->save();

            $this->dispatch('noty-updated', type: 'PERMISO', name: $permiso->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ACTUALIZAR');
        }
    }

    public function destroy($id)
    {
        try {
            $this->authorize('delete', $id);
            $rolesCount = Permission::find($id)->getRoleNames()->count();
            if ($rolesCount > 0) {
                $this->dispatch('showNotification', 'No se puede eliminar el role porque tiene permisos asociados', 'warning');
                return;
            }

            $permiso = Permission::find($id);
            Permission::find($id)->delete();
            $this->dispatch('noty-deleted', type: 'PERMISO', name: $permiso->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ELIMINAR');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'searchUpdated' => 'updateSearch',
    ];

    public function resetUI()
    {
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }

    public function updateSearch($search)
    {
        $this->search = $search;
    }
}
