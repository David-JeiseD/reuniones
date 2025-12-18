<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Asistencia</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .tardanza { color: red; font-weight: bold; }
        .presente { color: green; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE ASISTENCIA</h1>
        <h2>{{ $meeting->titulo }}</h2>
        <p><strong>Lugar:</strong> {{ $meeting->lugar }} | <strong>Fecha:</strong> {{ $meeting->fecha }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre y Apellidos</th>
                <th>Cargo</th>
                <th>UGEL</th>
                <th>Entrada</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencias as $as)
            <tr>
                <td>{{ $as->user->dni }}</td>
                <td>{{ $as->user->name }}</td>
                <td>{{ $as->user->cargo }}</td>
                <td>{{ $as->user->ugel->nombre ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($as->entrada)->format('H:i A') }}</td>
                <td class="{{ $as->estado == 'Tardanza' ? 'tardanza' : 'presente' }}">
                    {{ $as->estado }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Fecha de reporte: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>