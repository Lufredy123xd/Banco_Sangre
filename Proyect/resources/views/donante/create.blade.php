@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-user-plus me-2"></i>Registrar Nuevo Donante</h1>
    </div>

    <!-- Mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Mensajes de éxito/error -->
    @if (session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulario -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Datos del Donante</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('donante.store') }}" method="POST">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ old('id') }}">

                <!-- Sección 1: Información Personal -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Información Personal</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nombre" id="txt__nombre" required
                                    placeholder="Nombre" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                    title="Solo letras y espacios" value="{{ old('nombre') }}">
                                <label for="txt__nombre">Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="apellido" id="txt__apellido" required
                                    placeholder="Apellido" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                    title="Solo letras y espacios" value="{{ old('apellido') }}">
                                <label for="txt__apellido">Apellido</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="cedula" id="txt__cedula" required
                                    placeholder="Cédula" maxlength="8" pattern="\d{8}"
                                    title="Debe contener exactamente 8 dígitos" value="{{ old('cedula') }}">
                                <label for="txt__cedula">Cédula</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" name="telefono" id="txt__telefono" required
                                    placeholder="Teléfono" maxlength="15" pattern="\d{7,15}"
                                    title="7-15 dígitos" value="{{ old('telefono') }}">
                                <label for="txt__telefono">Teléfono</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="fecha_nacimiento" id="txt__fecha" required
                                    max="{{ date('Y-m-d') }}" title="Fecha no puede ser posterior a hoy"
                                    value="{{ old('fecha_nacimiento') }}">
                                <label for="txt__fecha">Fecha de Nacimiento</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="txt_sexo" name="sexo" class="form-select" required>
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                <label for="txt_sexo">Sexo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Datos Sanguíneos -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="fas fa-tint me-2"></i>Datos Sanguíneos</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="ABO" id="txt__abo" required>
                                    @foreach (App\Enums\TipoABO::cases() as $tipo)
                                        <option value="{{ $tipo->value }}" {{ old('ABO') == $tipo->value ? 'selected' : '' }}>
                                            {{ $tipo->value }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="txt__abo">Grupo ABO</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="RH" id="txt__rh" required>
                                    @foreach (App\Enums\TipoRH::cases() as $tipo)
                                        <option value="{{ $tipo->value }}" {{ old('RH') == $tipo->value ? 'selected' : '' }}>
                                            {{ $tipo->value }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="txt__rh">Factor RH</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Estado y Observaciones -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Estado y Observaciones</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="estado" id="estado" required>
                                    @foreach (App\Enums\EstadoDonante::cases() as $tipo)
                                        @if (!in_array($tipo->value, ['Diferido Permanente', 'Agendado', 'Para Actualizar']))
                                            <option value="{{ $tipo->value }}" {{ old('estado') == $tipo->value ? 'selected' : '' }}>
                                                {{ $tipo->value }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                                    placeholder="Observaciones" maxlength="255">{{ old('observaciones') }}</textarea>
                                <label for="observaciones">Observaciones</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('donante.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Registrar Donante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-floating textarea.form-control {
        height: auto;
        min-height: 100px;
    }
</style>
@endsection