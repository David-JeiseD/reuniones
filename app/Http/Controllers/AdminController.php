<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Meeting;
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::role('usuario')->count();
        $totalReuniones = Meeting::count();
        $reuniones = Meeting::orderBy('fecha', 'desc')->get();
        
        return view('admin.dashboard', compact('totalUsuarios', 'totalReuniones', 'reuniones'));
    }

    public function verAsistencias(Meeting $meeting)
    {
        // Traemos las asistencias con los datos del usuario
        $asistencias = Attendance::where('meeting_id', $meeting->id)
                                  ->with('user')
                                  ->get();

        return view('admin.asistencias', compact('meeting', 'asistencias'));
    }
    public function historialGeneral() {
        $asistencias = Attendance::with(['user', 'meeting'])->orderBy('created_at', 'desc')->get();
        return view('admin.historial_general', compact('asistencias'));
    }

    public function generarPDF(Meeting $meeting)
    {
        $asistencias = Attendance::where('meeting_id', $meeting->id)
                                ->with(['user.ugel']) // Traemos usuario y su ugel
                                ->get();

        // Cargamos una vista especial para el PDF
        $pdf = Pdf::loadView('admin.reports.attendance_pdf', compact('meeting', 'asistencias'));

        // Retornamos el PDF para descargar
        return $pdf->download('Asistencia-'.$meeting->titulo.'.pdf');
    }
}