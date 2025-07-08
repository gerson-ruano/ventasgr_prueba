<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name','address','email','phone','nit','image'];

    public function getImagenAttribute() {
        $imagePath = 'storage/companies/' . ($this->image ? $this->image : 'noimg.jpg');

        // Verifica si la imagen existe en la ruta especificada
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        } else {
            // Si la imagen no existe, muestra la imagen por defecto
            return asset('img/noimg.jpg');
        }
    }

    public function getImagenWebAttribute()
    {
        return asset('storage/companies/' . ($this->image ?: 'noimg.jpg'));
    }

    public function getImagenPdfAttribute()
    {
        return public_path('storage/companies/' . ($this->image ?: 'noimg.jpg'));
    }
}
