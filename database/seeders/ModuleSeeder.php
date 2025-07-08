<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void

    {
        /*DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivar llaves foráneas (opcional, si hay relaciones)
        Module::truncate(); // Elimina todo y reinicia los IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');*/

        $modulos = config('modules');

        foreach ($modulos as $key => $modulo) {

            // Si el módulo tiene hijos, los insertamos
            if (isset($modulo['children']) && is_array($modulo['children'])) {
                foreach ($modulo['children'] as $childKey => $child) {
                    Module::firstOrCreate(
                        ['name' => $childKey],
                        [
                            'description' => $child['label'] ?? ucfirst($childKey),
                            'active' => true,
                        ]
                    );
                }
            }

            // Si NO tiene hijos, lo insertamos directamente
            else {
                Module::firstOrCreate(
                    ['name' => $key],
                    [
                        'description' => $modulo['label'] ?? ucfirst($key),
                        'active' => true,
                    ]
                );
            }
        }
    }
}
