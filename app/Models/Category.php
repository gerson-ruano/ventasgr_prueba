<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute() {
        $imagePath = 'storage/categories/' . ($this->image ? $this->image : 'noimg.jpg');

        // Verifica si la imagen existe en la ruta especificada
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        } else {
            // Si la imagen no existe, muestra la imagen por defecto
            return asset('assets/img/noimg.jpg');
        }
    }
}


