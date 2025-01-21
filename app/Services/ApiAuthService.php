<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ApiAuthService
{
    protected $accessToken;
    protected $refreshToken;

    public function getAccessToken()
    {
        try {
            if (Cache::has('access_token')) {
                //\Log::info('Token obtenido de caché: ' . Cache::get('access_token'));
                return Cache::get('access_token');
            }

            //\Log::info('El token no está en caché. Intentando autenticación...');
            return $this->authenticate();
        } catch (\Exception $e) {
            //\Log::error('Error al obtener el token: ' . $e->getMessage());
            throw $e;
        }
    }

    public function authenticate()
    {
        try {
            $response = Http::asForm()->post(config('factus.url'), [
                'grant_type' => 'password',
                'client_id' => config('factus.client_id'),
                'client_secret' => config('factus.client_secret'),
                'username' => config('factus.username'),
                'password' => config('factus.password'),
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $this->accessToken = $data['access_token'];
                $this->refreshToken = $data['refresh_token'];

                // Almacena el token en caché
                Cache::put('access_token', $this->accessToken, now()->addMinutes(59));
                Cache::put('refresh_token', $this->refreshToken, now()->addDays(1));

                //return $data;
                return $this->accessToken;
            }

            // Manejo de errores en la respuesta
            \Log::error('Error de autenticación: ' . $response->body());
            throw new \Exception('Error de autenticación: ' . $response->body());
        } catch (\Exception $e) {
            \Log::error('Excepción en la autenticación: ' . $e->getMessage());
            throw new \Exception('Excepción en la autenticación: ' . $e->getMessage());
        }

    }
}
