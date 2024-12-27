<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class CashoutPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct('cashout');
    }
    public function hasPermissionTo(User $user, Model $sale): bool
    {
        // Implement your permission logic here
        // For example, check if the sale belongs to the user
        return $sale->user_id === $user->id;
    }

}
