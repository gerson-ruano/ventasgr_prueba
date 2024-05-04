<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name'=>'LARAVEL',
            'cost'=> 200,
            'price'=> 350,
            'barcode'=>'2342252524',
            'stock'=> 1000,
            'alerts'=> 10,
            'category_id'=> 1,
            'image'=>'curso.png'
        ]);
        Product::create([
            'name'=>'RUNING',
            'cost'=> 600,
            'price'=> 850,
            'barcode'=>'234234535524',
            'stock'=> 100,
            'alerts'=> 10,
            'category_id'=> 2,
            'image'=>'tenis.png'
        ]);
        Product::create([
            'name'=>'IPHONE 13',
            'cost'=> 10200,
            'price'=> 3530,
            'barcode'=>'23423543524',
            'stock'=> 230,
            'alerts'=> 10,
            'category_id'=> 3,
            'image'=>'telefono.png'
        ]);
        Product::create([
            'name'=>'PC GAMER',
            'cost'=> 2200,
            'price'=> 730,
            'barcode'=>'2322219724',
            'stock'=> 356,
            'alerts'=> 10,
            'category_id'=> 4,
            'image'=>'computadora.png'
        ]);
    }
}
