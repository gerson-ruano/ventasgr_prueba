<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //use HasFactory;
    protected $fillable = ['key', 'value', 'type', 'options'];

    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function getOptionsArrayAttribute()
    {
        return $this->options ? explode(',', $this->options) : [];
    }
    /*public static function delete($key)
    {
        return static::where('key', $key)->delete();
    }*/

}
