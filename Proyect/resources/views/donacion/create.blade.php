@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Tarjeta de registro -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Registrar Nueva Donación</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('/donacion') }}" method="POST">
                @csrf

                <!-- Información del donante -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-user-tag me-2"></i>Datos del Donante</h5>
                    <hr class="mt-1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" 
                                       value="{{ $donante->nombre }} {{ $donante->apellido }}" 
                                       id="donanteNombre" readonly>
                                <label for="donanteNombre">Nombre Completo</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" 
                                       value="{{ $donante->cedula }}" 
                                       id="donanteCedula" readonly>
                                <label for="donanteCedula">Cédula</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_donante" value="{{ $donante->id }}">

                <!-- Detalles de la donación -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-tint me-2"></i>Detalles de la Donación</h5>
                    <hr class="mt-1">
                    <div class="row g-3">
                        <!-- Fecha -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                                <label for="fecha">Fecha de Donación</label>
                            </div>
                        </div>

                        <!-- Clase de Donación -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="clase_donacion" name="clase_donacion" class="form-select" required>
                                    @foreach (App\Enums\TipoDonacion::cases() as $tipo)
                                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                                    @endforeach
                                </select>
                                <label for="clase_donacion">Clase de Donación</label>
                            </div>
                        </div>

                        <!-- Serología -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="serologia" name="serologia" class="form-select" required>
                                    @foreach (App\Enums\TipoSerologia::cases() as $tipo)
                                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                                    @endforeach
                                </select>
                                <label for="serologia">Serología</label>
                            </div>
                        </div>

                        <!-- Anticuerpos Irregulares -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="anticuerpos_irregulares" name="anticuerpos_irregulares" class="form-select" required>
                                    @foreach (App\Enums\TipoAnticuerposIrregulares::cases() as $tipo)
                                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                                    @endforeach
                                </select>
                                <label for="anticuerpos_irregulares">Anticuerpos Irregulares</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('gestionarDonante', ['id' => $donante->id]) }}" 
                       class="btn btn-outline-secondary">
                       <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Registrar Donación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Establecer la fecha actual como valor predeterminado
    const fechaInput = document.getElementById('fecha');
    const today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
    
    // Validación para no permitir fechas futuras
    fechaInput.max = today;
});
</script>
@endsection