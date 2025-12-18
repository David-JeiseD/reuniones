@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Usuarios</h5>
                    <h2>{{ $totalUsuarios }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Reuniones Creadas</h5>
                    <h2>{{ $totalReuniones }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <a href="{{ route('meetings.create') }}" class="btn btn-dark btn-lg w-100">+ Nueva Reunión</a>  
            <a href="{{ route('ugels.index') }}" class="btn btn-success btn-lg w-100">Configurar UGELs</a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white"><strong>Historial de Reuniones</strong></div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th>Lugar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reuniones as $m)
                    <tr>
                        <td>{{ $m->fecha }}</td>
                        <td>{{ $m->titulo }}</td>
                        <td>{{ $m->lugar }}</td>
                        <td>
                            <a href="{{ route('admin.meetings.asistencias', $m->id) }}" class="btn btn-sm btn-info text-white">Ver Asistencias</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection