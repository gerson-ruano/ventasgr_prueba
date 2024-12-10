<?php

use App\Models\User;

if (!function_exists('getNameSeller')) {
    function getNameSeller($seller)
    {
        $vendedor = User::find($seller);
        return $vendedor ? $vendedor->name : 'Consumidor Final';
    }
}
