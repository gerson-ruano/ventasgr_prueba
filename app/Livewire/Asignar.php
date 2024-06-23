<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class Asignar extends Component
{

    use WithPagination;

    public $role, $componentName, $permisosSelected = [], $old_permissions = [];
    public $isModalOpen = false;
    private $pagination = 10;

    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = 'Asignar Permisos';
    }

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function render()
    {
        $permisos = Permission::select('name','id', DB::raw("0 as checked"))
        ->orderBy('name','asc')
        ->paginate($this->pagination);

        if($this->role != 'Elegir')
        {
            $list = Permission::join('role_has_permissions as rp','rp.permission_id','permissions.id')
            ->where('role_id', $this->role)->pluck('permissions.id')->toArray();
            $this->old_permissions = $list;
        }
        if($this->role != 'Elegir')
        {
            foreach ($permisos as $permiso)
            {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);
                if($tienePermiso){
                    $permiso->checked = 1;
                }
            }
        }

        return view('livewire.asignar.components',[
            'roles' =>  Role::orderBy('name','asc')->get(),
            'permisos' => $permisos,
        ])->extends('layouts.app')
        ->section('content');
    }

    public $listeners = ['revokeall' => 'Removeall'];

    public function Removeall()
    {
        if($this->role == 'Elegir')
        {
            $this->dispatch('showNotification', 'Selecciona un rol válido', 'error');
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);

        //$this->dispatch('removeall',"Se revocaron todos los permisos al role $role->name ");
        $this->dispatch('showNotification', 'Se revocaron todos los permisos al role', 'success');
    }

    public function SyncAll()
    {
        if($this->role == 'Elegir')
        {
            $this->dispatch('showNotification', 'No se realizo la sincronización', 'error');
            return;
        }

        $role = Role::find($this->role);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);
        //$this->dispatch('syncall', "Se sincronizaron todos los permisos al role", $role->name);
        $this->dispatch('showNotification', 'Se sincronizaron todos los permisos al role', 'success');
        
    }

    public function syncPermiso($state, $permisoName)
    {
        if($this->role != 'Elegir')
        {
            $roleName = Role::find($this->role);
            if($state)
            {
                $roleName->givePermissionTo($permisoName);
                $this->dispatch('showNotification', 'Permiso asignado correctamente', 'success');
                
            }else{
                $roleName->revokePermissionTo($permisoName);
                $this->dispatch('showNotification', 'Permiso eliminado correctamente', 'warning');
            }

        }else {
            $this->dispatch('showNotification', 'Elige un rol válido', 'error');
        }

    }
}
