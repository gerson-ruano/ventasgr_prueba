<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $fillable = ['total', 'items','cash','change','status','user_id','seller','taxes','customer_data'];

    protected $casts = [
        'customer_data' => 'array',
    ];
    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id'); // Relación 1 a muchos
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller', 'id'); // Ajusta los nombres de las columnas si son diferentes
    }

}

