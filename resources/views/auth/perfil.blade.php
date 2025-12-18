@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">Mi Perfil</div>
                <div class="card-body text-center">
                    <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Foto de Perfil -->
                        <div class="mb-3">
                            <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                                 class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            <input type="file" name="avatar" class="form-control mt-2">
                        </div>

                        <div class="text-start">
                            <label>Nombre Completo (DNI: {{ auth()->user()->dni }})</label>
                            <input type="text" name="name" class="form-control mb-3" value="{{ auth()->user()->name }}">

                            <label>Cargo</label>
                            <select name="cargo" class="form-control mb-3">
                                <option value="Director" {{ auth()->user()->cargo == 'Director' ? 'selected' : '' }}>Director</option>
                                <option value="Auxiliar" {{ auth()->user()->cargo == 'Auxiliar' ? 'selected' : '' }}>Auxiliar</option>
                                <option value="Docente" {{ auth()->user()->cargo == 'Docente' ? 'selected' : '' }}>Docente</option>
                            </select>

                            <label>UGEL</label>
                            <select name="ugel_id" class="form-control mb-3">
                                @foreach($ugels as $ugel)
                                    <option value="{{ $ugel->id }}" {{ auth()->user()->ugel_id == $ugel->id ? 'selected' : '' }}>
                                        {{ $ugel->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Actualizar Mis Datos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection