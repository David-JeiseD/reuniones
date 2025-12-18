<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ugel;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
   
    public function showCompletarPerfil() {
        // Si el perfil ya está completo, lo mandamos al home
        if (auth()->user()->perfil_completo) {
            return redirect('/home');
        }
    
        $ugels = Ugel::all(); // Traemos todas las UGELs de la tabla
        return view('auth.completar_perfil', compact('ugels'));
    }

    public function storeCompletarPerfil(Request $request) {
        $request->validate([
            'cargo' => 'required|in:Director,Auxiliar,Docente',
            'ugel_id' => 'required|exists:ugels,id' // Validamos que el ID exista en la tabla ugels
        ]);
    
        $user = auth()->user();
        $user->update([
            'cargo' => $request->cargo,
            'ugel_id' => $request->ugel_id,
            'perfil_completo' => true
        ]);
    
        return redirect('/home')->with('success', '¡Perfil completado! Bienvenido al sistema.');
    }
    

    public function perfil() {
        $ugels = Ugel::all();
        return view('auth.perfil', compact('ugels'));
    }
    
    public function actualizarPerfil(Request $request) {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ugel_id' => 'required',
            'cargo' => 'required'
        ]);
    
        $data = $request->only('name', 'cargo', 'ugel_id');
    
        if ($request->hasFile('avatar')) {
            // Borrar foto anterior si existe
            if ($user->avatar) { Storage::delete('public/'.$user->avatar); }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }
    
        $user->update($data);
        return back()->with('success', 'Perfil actualizado correctamente');
    }
}
