@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Campo DNI -->
                        <div class="row mb-3">
                            <label for="dni" class="col-md-4 col-form-label text-md-end">DNI</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="dni" type="text" class="form-control @error('dni') is-invalid @enderror" name="dni" value="{{ old('dni') }}" required maxlength="8">
                                    <button class="btn btn-primary" type="button" id="btn-buscar">
                                        <span id="btn-text">Buscar</span>
                                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                </div>
                                @error('dni')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Nombre (ReadOnly) -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre Completo</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required readonly>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success w-100">
                                    Registrarse e Iniciar Sesión
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para la búsqueda -->
<script>
document.getElementById('btn-buscar').addEventListener('click', function() {
    const dni = document.getElementById('dni').value;
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    const btnBuscar = document.getElementById('btn-buscar');

    if (dni.length !== 8) {
        Swal.fire('Atención', 'El DNI debe tener 8 dígitos', 'warning');
        return;
    }

    // Mostrar spinner
    btnText.classList.add('d-none');
    btnSpinner.classList.remove('d-none');
    btnBuscar.disabled = true;

    fetch(`/consulta-dni/${dni}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('name').value = data.nombre_completo;
                Swal.fire('Logrado', 'Datos encontrados', 'success');
            } else {
                Swal.fire('Error', 'No se encontró el DNI', 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Hubo un problema con la API', 'error');
        })
        .finally(() => {
            // Ocultar spinner
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
            btnBuscar.disabled = false;
        });
});
</script>
@endsection
