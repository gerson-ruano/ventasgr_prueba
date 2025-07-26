<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class ConfiguracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        /*DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivar llaves foráneas (opcional, si hay relaciones)
        Setting::truncate(); // Elimina todo y reinicia los IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');*/

        $settings = [
            ['key' => 'products_show_stock', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'pos_tax_rate', 'value' => '12', 'type' => 'number'],
            ['key' => 'pos_discount_rate', 'value' => '0', 'type' => 'number'],
            ['key' => 'low_stock', 'value' => '10', 'type' => 'number'],
            ['key' => 'app_name', 'value' => 'Mi Sistema', 'type' => 'string'],
            /*['key' => 'app_logo', 'value' => 'img/ventasgr_logo.png', 'type' => 'string'],*/
            ['key' => 'app_currency', 'value' => 'Q', 'type' => 'select', 'options' => 'Q,$,€'],
            ['key' => 'app_timezone', 'value' => 'America/Guatemala', 'type' => 'string'],
            ['key' => 'app_language', 'value' => 'en', 'type' => 'select', 'options' => 'en,es,fr,de'],
            ['key' => 'max_login_attempts', 'value' => '5', 'type' => 'number'],
            ['key' => 'password_min_length', 'value' => '8', 'type' => 'number'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean'],
            ['key' => 'report_format', 'value' => 'pdf', 'type' => 'select', 'options' => 'pdf,csv,xlsx'],
            ['key' => 'report_range', 'value' => '30', 'type' => 'select', 'options' => '7,15,30,60,90'],
            ['key' => 'app_theme', 'value' => 'light', 'type' => 'select', 'options' => 'light,dark'],
            ['key' => 'enable_notifications', 'value' => 'true', 'type' => 'boolean']
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
