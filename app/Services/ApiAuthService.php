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
                return Cache::get('access_token');
            }
            return $this->authenticate();
        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Servicio no disponible. Intente más tarde.'], 503);
        }
    }

    public function authenticate()
    {
        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post(config('factus.url'), [
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

                Cache::put('access_token', $this->accessToken, now()->addMinutes(59));
                Cache::put('refresh_token', $this->refreshToken, now()->addDays(1));

                return $this->accessToken;
            } elseif ($response->serverError()) {
                throw new \Exception('Error del servidor en la API.');
            } elseif ($response->clientError()) {
                throw new \Exception('Error de cliente: ' . $response->body());
            }

            throw new \Exception('Respuesta inesperada: ' . $response->body());
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return response()->json(['error' => 'No se pudo conectar con el servicio API.'], 503);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la autenticación: ' . $e->getMessage()], 500);
        }
    }
}

