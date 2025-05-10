<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Sale;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class Users extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $profile;
    public $pageTitle, $componentName, $search, $perfilSeleccionado, $imageUrl;

    private $pagination = 10;
    public $isModalOpen = false;

    protected function rules()
    {

        $rules = [
            'name' => 'required|min:3|unique:users,name,' . $this->selected_id,
            'email' => 'required|email|unique:users,email,' . $this->selected_id,
            'phone' => 'max:8',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'name.unique' => 'El nombre de usuario ya existe en el sistema',
            'email.required' => 'Ingresa un correo',
            'email.email' => 'Ingresa un correo valido',
            'phone.min' => 'Ingrese un numero valido',
            'phone.max' => 'El numero telefonico debe tener 8 digitos',
            'email.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el Estado del usuario',
            'status.not_in' => 'Selecciona el Estado',
            'profile.required' => 'Selecciona el Perfil/Rol del usuario',
            'profile.not_in' => 'Selecciona el Perfil/Rol distinto a Elegir',
            //'password.required' => 'Ingresa el Password',
            'password.min' => 'El password debe tener al menos 4 caracteres'
        ];

        if ($this->password) {
            $rules['password'] = 'required|min:4';
        }

        return $rules;
    }


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
        $query = User::query();

        if (!empty($this->perfilSeleccionado)) {
            $query->where('profile', $this->perfilSeleccionado);
        }

        if (strlen($this->search) > 0) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $data = $query->select('*')->orderBy('name', 'asc')->paginate($this->pagination);

        $valores = $this->filtroTipoPerfil();

        return view('livewire.users.components', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'users' => $data,
            'valores' => $valores,
        ])->extends('layouts.app')
            ->section('content');
    }

    public function filtroTipoPerfil()
    {
        //return User::pluck('profile')->unique()->toArray();
        return User::distinct('profile')->pluck('profile')->toArray();
        //return $valores;
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
            //$this->rules['password'] = 'required|min:4';
            $this->validate($this->rules());
            $this->authorize('users.create', Users::class);

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'status' => $this->status,
                'profile' => $this->profile,
                'password' => bcrypt($this->password)
            ]);

            //$user->syncRoles($this->profile);
            // Asignar rol: buscar el rol por ID y asignar el nombre
            $role = Role::find($this->profile);
            if ($role) {
                $user->syncRoles($role->name); // Asigna el nombre del rol
            } else {
                // Manejo de error si el rol no existe
                $this->dispatch('noty-error', type: 'error', message: 'El rol seleccionado no existe.');
                return;
            }

            if ($this->image) {
                $customFileName = uniqid() . ' _.' . $this->image->extension();
                $this->image->storeAs('public/users', $customFileName);
                $user->image = $customFileName;
                $user->save();
            }
            $this->dispatch('noty-added', type: 'USUARIO', name: $user->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'CREAR');
        }

    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->imageUrl = null;
        $this->search = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();

    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->imageUrl = $user->image ? Storage::url('users/' . $user->image) : null;
        $this->password = '';

        $this->profile = $user->roles->first()->id ?? $this->profile;

        $this->openModal();
    }

    public function update()
    {
        try {
            // Validación
            $this->validate($this->rules());
            $this->authorize('users.update', $this->selected_id);

            $user = User::find($this->selected_id);

            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'status' => $this->status,
                'profile' => $this->profile,
            ];

            if (!empty($this->password)) {
                $data['password'] = bcrypt($this->password);
            }

            $user->update($data);

            //$user->syncRoles($this->profile);
            $role = Role::find($this->profile);

            if ($role) {
                $user->syncRoles($role->name); // Asignar el nombre del rol
            } else {
                $this->dispatch('noty-error', type: 'error', message: 'El rol seleccionado no existe.');
                return;
            }

            if ($this->image) {
                $customFileName = uniqid() . ' _.' . $this->image->extension();
                $this->image->storeAs('public/users', $customFileName);
                $imageTemp = $user->image;

                $user->image = $customFileName;
                $user->save();

                if ($imageTemp != null) {
                    if (file_exists('storage/users/' . $imageTemp)) {
                        unlink('storage/users/' . $imageTemp);
                    }
                }

            }
            $this->dispatch('noty-updated', type: 'USUARIO', name: $user->name);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            // Notificación de error de autorización
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ACTUALIZAR');
        }

    }

    public function destroy($id)
    {
        try {

            $user = User::find($id);
            $this->authorize('users.delete', $user);
            if (!$user) {
                // Manejo de caso donde el usuario no se encuentra
                $this->dispatch('noty-not-found', type: 'USUARIO', name: $user->id);
                return;
            }

            // Contar las ventas asociadas al usuario
            $salesCount = Sale::where('user_id', $user->id)->count();

            if ($salesCount > 0) {
                // Manejo de caso donde el usuario tiene ventas asociadas
                $this->dispatch('showNotification', 'No se puede eliminar el Usuario porque tiene ventas asociadas', 'warning');
                return;
            }

            // Guardar el nombre de la imagen antes de eliminar el usuario
            $imageName = $user->image;
            $userDelete = $user->name;

            $user->delete();

            // Eliminar la imagen del almacenamiento si existe
            if ($imageName && file_exists(storage_path('app/public/users/' . $imageName))) {
                unlink(storage_path('app/public/users/' . $imageName));
            }

            // Emitir evento de notificación de eliminación exitosa
            $this->dispatch('noty-deleted', type: 'USUARIO', name: $userDelete);
        } catch (\Illuminate\Auth\Access\AuthorizationException $exception) {
            $this->dispatch('noty-permission', type: 'USUARIO', name: 'PERMISOS', permission: 'ELIMINAR');
        }
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'tema' => 'required|in:0,1',
        ]);

        $user = auth()->user();
        $user->tema = $request->tema;
        $user->save();

        //\Log::info('Tema actualizado a: ' . $request->tema);

        return response()->json(['success' => true]);

    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'searchUpdated' => 'updateSearch',
    ];

    public function updateSearch($search)
    {
        $this->search = $search;
    }

}
