@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Nueva UGEL</div>
                <div class="card-body">
                    <form action="{{ route('ugels.store') }}" method="POST">
                        @csrf
                        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre de la UGEL" required>
                        <button class="btn btn-primary w-100">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Lista de UGELs Disponibles</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Usuarios</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ugels as $u)
                            <tr>
                                <td>{{ $u->nombre }}</td>
                                <td>{{ $u->users_count ?? 0 }}</td>
                                <td>
                                    <form action="{{ route('ugels.destroy', $u->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection