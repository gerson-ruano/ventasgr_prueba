<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class Roles extends Component
{

    use WithPagination;

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    public $isModalOpen = false;
    private $pagination = 10;

    protected $rules = [
        'roleName' => 'required|min:3|unique:roles,name'
    ];

    protected $messages = [
        'roleName.required' => 'Él nombre del rol es requerido',
        'roleName.unique' => 'El rol ya existe',
        'roleName.min' => 'El nombre del role debe tener como minimo 2 caracteres'
    ];

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Role::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Role::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.roles.components', ['roles' => $data])
            ->extends('layouts.app')
            ->section('content');
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
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
            $this->authorize('create', Role::class);

            Role::create([
                'name' => $this->roleName
            ]);

            $this->dispatch('noty-added', type: 'ROL', name: $this->roleName);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'CREAR');
        }
    }

    public function edit(Role $role)
    {
        //$role = Role::find($id);
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->openModal();
    }

    public function update()
    {
        try {
            // Actualización de reglas de validación para la edición
            $this->rules['roleName'] = "required|min:3|unique:roles,name, {$this->selected_id}";

            // Validación
            $this->validate();
            $this->authorize('update', $this->selected_id);

            $role = Role::find($this->selected_id);
            $role->name = $this->roleName;
            $role->save();

            $this->dispatch('noty-updated', type: 'ROLE', name: $role->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ACTUALIZAR');
        }

    }

    public function destroy($id)
    {
        try {
            $this->authorize('delete', $id);
            $permissionCount = Role::find($id)->permissions()->count();
            if ($permissionCount > 0) {
                $this->dispatch();
                return;
            }

            $role = Role::find($id);
            Role::find($id)->delete();
            // Restablecer UI y emitir evento
            $this->dispatch('noty-deleted', type: 'ROL', name: $role->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ELIMINAR');
        }

    }

    //Esta funcion no se utiliza en teoria se utiliza en USERS
    /*public function AsignarRoles($rolesList)
    {
        if($this->userSelected > 0)
        {
            $user = User::find($this->userSelected);
            if($user){
                $user->syncRoles($rolesList);
                $this->dispatch('showNotification', 'Roles asignados correctamente', 'info');
                $this->resetInput();
            }
        }
    }*/

    protected $listeners = [
        'deleteRow' => 'destroy',
        'searchUpdated' => 'updateSearch',
    ];

    public function resetUI()
    {
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }

    public function updateSearch($search)
    {
        $this->search = $search;
    }

}
