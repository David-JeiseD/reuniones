@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Asistencia: {{ $meeting->titulo }}</h3>
        <div>
        <!-- BOTÓN NUEVO -->
        <a href="{{ route('admin.meetings.pdf', $meeting->id) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver</a>
    </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>UGEL</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asistencias as $as)
                    <tr>
                        <td>{{ $as->user->dni }}</td>
                        <td>
                            <img src="{{ $as->user->avatar ? asset('storage/'.$as->user->avatar) : 'https://ui-avatars.com/api/?name='.$as->user->name }}" 
                                class="rounded-circle" style="width: 40px; height: 40px;">
                        </td>
                        <td>{{ $as->user->name }}</td>
                        <td>{{ $as->user->cargo }}</td>
                        <td>{{ $as->user->ugel->nombre ?? 'N/A' }}</td> 
                       
                        
                        <td><span class="badge bg-success">{{ \Carbon\Carbon::parse($as->entrada)->format('H:i A') }}</span></td>
                        <td>
                            @if($as->salida)
                                <span class="badge bg-danger">{{ \Carbon\Carbon::parse($as->salida)->format('H:i A') }}</span>
                            @else
                                <span class="text-muted">No marcó</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nadie ha marcado asistencia todavía.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection