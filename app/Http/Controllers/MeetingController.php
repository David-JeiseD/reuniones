<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;


class MeetingController extends Controller
{
    public function index() {
        $meetings = Meeting::orderBy('fecha', 'desc')->get();
        return view('admin.dashboard', compact('meetings')); // O una vista específica
    }

    public function create() {
        return view('admin.meetings.create'); // La vista del mapa que hicimos
    }

    public function store(Request $request) {
        $data = $request->validate([
            'titulo' => 'required',
            'lugar' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
        ]);

        Meeting::create($data); // Ahora solo enviamos los datos limpios
        return redirect()->route('admin.dashboard')->with('success', 'Reunión creada');
    }
}
