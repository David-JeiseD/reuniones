@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Crear Nueva Reunión</div>
        <div class="card-body">
            <form action="{{ route('meetings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Título de la Reunión</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Ubicación (Nombre del lugar)</label>
                    <input type="text" name="lugar" id="lugar" class="form-control" placeholder="Ej: Auditorio Central" required>
                </div>

                <!-- Contenedor del Mapa -->
                <label>Seleccione ubicación en el mapa:</label>
                <div id="map" style="height: 300px; margin-bottom: 20px;"></div>

                <!-- Campos ocultos para coordenadas -->
                <input type="hidden" name="latitud" id="lat">
                <input type="hidden" name="longitud" id="lng">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Hora Inicio</label>
                        <input type="time" name="hora_inicio" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Guardar Reunión</button>
            </form>
        </div>
    </div>
</div>

<!-- Leaflet CSS y JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Inicializar mapa en una coordenada central (Ej: Perú)
    var map = L.map('map').setView([-9.9306, -76.2422], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker;

    map.on('click', function(e) {
        if (marker) { map.removeLayer(marker); }
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
    });
</script>
@endsection