<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name'=> 'CURSOS',
            'image'=> 'laravel.png'
        ]);
        Category::create([
            'name'=> 'ZAPATOS',
            'image'=> 'zapatos.png'
        ]);
        Category::create([
            'name'=> 'CELULARES',
            'image'=> 'telefono.png'
        ]);
        Category::create([
            'name'=> 'COMPUTADORAS',
            'image'=> 'computadora.png'
        ]);
    }
}
