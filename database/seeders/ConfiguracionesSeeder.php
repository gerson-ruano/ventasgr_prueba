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
        $settings = [
            ['key' => 'products_show_stock', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'pos_tax_rate', 'value' => '0.12', 'type' => 'number'],
            ['key' => 'app_name', 'value' => 'Mi Sistema', 'type' => 'string'],
            ['key' => 'app_logo', 'value' => 'logo.png', 'type' => 'string'],
            ['key' => 'app_currency', 'value' => 'Qtz', 'type' => 'string'],
            ['key' => 'app_timezone', 'value' => 'America/Guatemala', 'type' => 'string'],
            ['key' => 'app_language', 'value' => 'en', 'type' => 'select', 'options' => 'en,es,fr,de'],
            ['key' => 'default_role', 'value' => 'User', 'type' => 'string'],
            ['key' => 'max_login_attempts', 'value' => '5', 'type' => 'number'],
            ['key' => 'password_min_length', 'value' => '8', 'type' => 'number'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean'],
            ['key' => 'report_format', 'value' => 'pdf', 'type' => 'select', 'options' => 'pdf,csv,xlsx'],
            ['key' => 'report_range', 'value' => '30', 'type' => 'select', 'options' => '7,15,30,60,90'],
            ['key' => 'app_theme', 'value' => 'light', 'type' => 'select', 'options' => 'light,dark'],
            ['key' => 'enable_notifications', 'value' => 'true', 'type' => 'boolean'],
            ['key' => 'default_language', 'value' => 'en', 'type' => 'select', 'options' => 'en,es,fr,de']
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
