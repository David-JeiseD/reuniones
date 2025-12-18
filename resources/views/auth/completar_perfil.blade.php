@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg mt-5">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Paso Final: Datos Laborales</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center">Para continuar, por favor selecciona tu cargo y UGEL correspondiente.</p>
                    
                    <form method="POST" action="{{ route('perfil.guardar') }}">
                        @csrf
                        
                        <!-- Selector de Cargo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Selecciona tu Cargo</label>
                            <select name="cargo" class="form-control form-select-lg" required>
                                <option value="" selected disabled>Elija un cargo...</option>
                                <option value="Director">Director</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Docente">Docente</option>
                            </select>
                        </div>

                        <!-- Selector de UGEL (Dinámico desde BD) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">UGEL a la que pertenece</label>
                            <select name="ugel_id" class="form-control form-select-lg" required>
                                <option value="" selected disabled>Seleccione su UGEL...</option>
                                @foreach($ugels as $ugel)
                                    <option value="{{ $ugel->id }}">{{ $ugel->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                            Guardar y Entrar al Sistema
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection