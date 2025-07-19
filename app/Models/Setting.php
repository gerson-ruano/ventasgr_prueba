<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //use HasFactory;
    protected $fillable = ['key', 'value', 'type', 'options'];
    protected $casts = [
        'options' => 'string',
    ];

    /**
     * Obtener valor ya interpretado según su tipo
     */
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($value) ? (float) $value : 0;
            default:
                return $value;
        }
    }

    /**
     * Guardar el valor interpretando el tipo
     */
    public function setValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                $this->attributes['value'] = $value ? '1' : '0';
                break;
            case 'number':
                $this->attributes['value'] = (string) $value; // se guarda como string en DB
                break;
            default:
                $this->attributes['value'] = $value;
                break;
        }
    }

    /**
     * Retorna las opciones como array (para tipos select, radio, etc.)
     */
    public function getOptionsArrayAttribute()
    {
        return $this->options ? array_map('trim', explode(',', $this->options)) : [];
    }

    /**
     * Obtener un valor por clave
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Establecer un valor por clave
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

}
