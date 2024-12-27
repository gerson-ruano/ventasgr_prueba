<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create');
    }

    public function update(User $user, Model $model)
    {
        // Lógica específica para actualizar un producto
        return $user->hasPermissionTo('update') || $model->user_id == $user->id;
    }

    public function delete(User $user, Product $product)
    {
        // Lógica específica para eliminar un producto
        return $user->hasPermissionTo('delete');
    }

// Otros métodos comunes como update, delete, restore, etc.
}
