<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Attendance;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hoy = now()->format('Y-m-d');
        
        // Reunión de hoy
        $reunion = \App\Models\Meeting::where('fecha', $hoy)->first();
    
        $asistencia = null;
        if($reunion){
            $asistencia = \App\Models\Attendance::where('user_id', auth()->id())
                                    ->where('meeting_id', $reunion->id)
                                    ->first();
        }
    
        // Próximas reuniones (no incluye la de hoy)
        $proximasReuniones = \App\Models\Meeting::where('fecha', '>', $hoy)
                                    ->orderBy('fecha', 'asc')
                                    ->get();
    
        $miHistorial = Attendance::where('user_id', auth()->id())
                              ->with('meeting')
                              ->orderBy('entrada', 'desc')
                              ->get();

        return view('home', compact('reunion', 'asistencia', 'proximasReuniones', 'miHistorial'));
    }
}
