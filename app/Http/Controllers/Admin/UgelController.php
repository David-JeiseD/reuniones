<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ugel;
use Illuminate\Http\Request;

class UgelController extends Controller
{
    public function index() {
        $ugels = Ugel::all();
        return view('admin.ugels.index', compact('ugels'));
    }

    public function store(Request $request) {
        // 1. Validamos (esto devuelve un array solo con los campos validados)
        $data = $request->validate([
            'nombre' => 'required|unique:ugels,nombre'
        ]);
    
        // 2. Usamos $data en lugar de $request->all()
        \App\Models\Ugel::create($data);
    
        return back()->with('success', 'UGEL creada correctamente.');
    }

    public function destroy(Ugel $ugel) {
        // Opcional: Validar que no haya usuarios usándola antes de borrar
        if($ugel->users()->count() > 0){
            return back()->with('error', 'No se puede borrar, hay usuarios en esta UGEL.');
        }
        $ugel->delete();
        return back()->with('success', 'UGEL eliminada.');
    }
}