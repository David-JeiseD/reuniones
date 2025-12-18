<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DniController extends Controller
{
    public function obtenerDatos($dni)
    {
        try {
            $token = env('API_PERU_TOKEN');
            
            if (!$token) {
                return response()->json(['success' => false, 'message' => 'Token no configurado'], 500);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post('https://apiperu.dev/api/dni', [
                'dni' => $dni,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success']) {
                    return response()->json([
                        'success' => true,
                        'nombre_completo' => $data['data']['nombre_completo'],
                    ]);
                }
            }

            return response()->json(['success' => false, 'message' => 'DNI no encontrado'], 404);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}