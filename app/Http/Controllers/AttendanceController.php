<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function marcarEntrada(Request $request)
    {
        $reunion = Meeting::findOrFail($request->meeting_id);
        
        // 1. Validar Distancia (Haversine)
        $distancia = $this->calcularDistancia($request->latitud, $request->longitud, $reunion->latitud, $reunion->longitud);
        
        if ($distancia > 0.150) { // 150 metros
            return response()->json(['success' => false, 'message' => 'Estás muy lejos del lugar.'], 403);
        }
    
        // 2. Validar Tiempo (Tardanza de 15 min)
        $horaInicio = \Carbon\Carbon::parse($reunion->fecha . ' ' . $reunion->hora_inicio);
        $ahora = now();
        
        // Si han pasado más de 15 minutos de la hora de inicio
        $estado = 'Presente';
        if ($ahora->gt($horaInicio->addMinutes(15))) {
            $estado = 'Tardanza';
            // OPCIONAL: Si quieres bloquear el registro después de 15 min, descomenta abajo:
            // return response()->json(['success' => false, 'message' => 'Ya pasaron 15 min. No puedes registrarte.'], 403);
        }
    
        Attendance::create([
            'user_id' => auth()->id(),
            'meeting_id' => $reunion->id,
            'entrada' => $ahora,
            'estado' => $estado
        ]);
    
        return response()->json(['success' => true, 'message' => "Asistencia marcada como: $estado"]);
    }
    
    public function marcarSalida(Request $request)
    {
        $asistencia = Attendance::where('user_id', auth()->id())
                                ->where('meeting_id', $request->meeting_id)
                                ->first();

        if ($asistencia) {
            $asistencia->update(['salida' => now()]);
            return response()->json(['success' => true, 'message' => 'Salida registrada. ¡Buen día!']);
        }
    }

    private function calcularDistancia($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Radio de la tierra en km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}