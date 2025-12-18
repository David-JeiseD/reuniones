@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- SECCIÓN: REUNIÓN DE HOY -->
        <div class="col-md-8 text-center mb-5">
            @if($reunion)
                <div class="card shadow-lg border-primary">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Reunión de Hoy</h4>
                    </div>
                    <div class="card-body py-4">
                        <h2 class="fw-bold">{{ $reunion->titulo }}</h2>
                        <p class="mb-1 lead"><i class="bi bi-geo-alt-fill text-danger"></i> <strong>Lugar:</strong> {{ $reunion->lugar }}</p>
                        <p class="text-muted"><strong>Hora de Inicio:</strong> {{ \Carbon\Carbon::parse($reunion->hora_inicio)->format('H:i A') }}</p>

                        <hr>

                        @if(!$asistencia)
                            <!-- Botón Entrada -->
                            <button id="btn-marcar" onclick="obtenerUbicacion('entrada')" class="btn btn-success btn-lg w-100 py-3 shadow">
                                <i class="bi bi-geo-alt"></i> MARCAR MI ENTRADA
                            </button>
                        @elseif($asistencia && !$asistencia->salida)
                            <!-- Botón Salida -->
                            <div class="alert alert-info py-3">
                                <i class="bi bi-clock-history"></i> Entrada marcada a las: 
                                <strong>{{ \Carbon\Carbon::parse($asistencia->entrada)->format('H:i A') }}</strong>
                            </div>
                            <button onclick="obtenerUbicacion('salida')" class="btn btn-danger btn-lg w-100 py-3 shadow">
                                <i class="bi bi-box-arrow-right"></i> MARCAR MI SALIDA
                            </button>
                        @else
                            <div class="alert alert-success border-2 shadow-sm">
                                <h4 class="alert-heading fw-bold mb-0">
                                    <i class="bi bi-check-circle-fill"></i> ¡Asistencia Completa!
                                </h4>
                                <p class="mb-0 mt-2">Ya registraste tu entrada y salida hoy.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card bg-light border-0 shadow-sm py-4">
                    <div class="card-body text-muted">
                        <i class="bi bi-calendar-x display-4"></i>
                        <p class="mt-2 lead">No hay reuniones programadas para hoy.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- SECCIÓN: PRÓXIMAS REUNIONES -->
        <div class="col-md-10 mb-5">
            <h4 class="mb-4 border-bottom pb-2 text-secondary"><i class="bi bi-calendar-event"></i> Calendario de Próximas Reuniones</h4>
            <div class="row">
                @forelse($proximasReuniones as $p)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        {{ \Carbon\Carbon::parse($p->fecha)->isoFormat('LL') }}
                                    </span>
                                    <small class="text-muted fw-bold">
                                        {{ \Carbon\Carbon::parse($p->hora_inicio)->format('H:i A') }}
                                    </small>
                                </div>
                                <h5 class="card-title fw-bold text-dark">{{ $p->titulo }}</h5>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt text-danger"></i> {{ $p->lugar }}
                                </p>
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $p->latitud }},{{ $p->longitud }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                                    Ver ubicación en mapa
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-3">
                        <p class="text-muted italic">No hay más reuniones programadas próximamente.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SECCIÓN: MI HISTORIAL -->
        <div class="col-md-10 mb-5">
            <h4 class="mb-3 text-secondary border-bottom pb-2"><i class="bi bi-clock-history"></i> Mi Historial de Asistencias</h4>
            <div class="table-responsive bg-white shadow-sm rounded">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Reunión</th>
                            <th>Fecha</th>
                            <th>Entrada</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($miHistorial as $h)
                        <tr>
                            <td>{{ $h->meeting->titulo }}</td>
                            <td>{{ \Carbon\Carbon::parse($h->meeting->fecha)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($h->entrada)->format('H:i A') }}</td>
                            <td>
                                @if($h->estado == 'Presente')
                                    <span class="badge bg-success">Presente</span>
                                @else
                                    <span class="badge bg-warning text-dark">Tardanza</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aún no tienes registros de asistencia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function obtenerUbicacion(tipo) {
    if (!navigator.geolocation) {
        Swal.fire('Error', 'Tu navegador no soporta geolocalización', 'error');
        return;
    }

    // Configuración para que el GPS sea más rápido y preciso
    const gpsOptions = {
        enableHighAccuracy: true, // Forzar uso de GPS real
        timeout: 10000,           // Esperar máximo 10 segundos
        maximumAge: 0             // No usar ubicaciones viejas guardadas en caché
    };

    Swal.fire({
        title: 'Detectando ubicación...',
        text: 'Por favor espera, estamos conectando con el GPS',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Decidir a qué ruta enviar los datos
            const url = tipo === 'entrada' ? "{{ route('asistencia.entrada') }}" : "{{ route('asistencia.salida') }}";

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    meeting_id: "{{ $reunion->id ?? '' }}",
                    latitud: lat,
                    longitud: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Logrado!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload(); // Recargar para ver los cambios
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Hubo un fallo al conectar con el servidor', 'error');
            });
        },
        (error) => {
            // Manejo detallado de errores de GPS
            let msg = 'Error desconocido al obtener ubicación';
            if(error.code === 1) msg = 'Debes permitir el acceso al GPS para marcar.';
            if(error.code === 2) msg = 'No se pudo determinar la ubicación (señal débil).';
            if(error.code === 3) msg = 'Se agotó el tiempo de espera para el GPS.';
            
            Swal.fire('Fallo de GPS', msg, 'error');
        },
        gpsOptions // Aplicamos las opciones aquí
    );
}
</script>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .badge { font-size: 0.9em; }
</style>
@endsection