<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_details';
    protected $fillable = ['price', 'quantity','product_id','sale_id','discount'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id'); // Relación inversa
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
