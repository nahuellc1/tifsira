<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\Producto::create([
        'codigo' => 'P001',
        'nombre' => 'Filtro de aceite',
        'categoria' => 'Filtros',
        'stock' => 30,
        'precio' => 4500.00,
    ]);
    }
}
