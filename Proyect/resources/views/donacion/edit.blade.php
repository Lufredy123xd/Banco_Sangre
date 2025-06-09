@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Mensaje de éxito -->
    @if (session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjeta de edición -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Donación</h2>
        </div>
        <div class="card-body">
            <form action="{{ url('/donacion/' . $donacion->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Información del donante -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-user me-2"></i>Información del Donante</h5>
                    <hr class="mt-1">
                    <div class="row g-3">
                        <div class="col-md-12">
                            @php
                                $donante = App\Models\Donante::find($donacion->id_donante);
                                $nombreCompleto = $donante->nombre . ' ' . $donante->apellido;
                            @endphp
                            <input type="hidden" id="id_donante" name="id_donante" value="{{ $donacion->id_donante }}">
                            <div class="form-floating">
                                <input value="{{ $nombreCompleto }}" class="form-control" id="donanteDisplay" readonly>
                                <label for="donanteDisplay">Donante</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles de la donación -->
                <div class="mb-4">
                    <h5 class="text-primary"><i class="fas fa-tint me-2"></i>Detalles de la Donación</h5>
                    <hr class="mt-1">
                    <div class="row g-3">
                        <!-- Fecha -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fecha" name="fecha" 
                                       value="{{ $donacion->fecha }}" required>
                                <label for="fecha">Fecha de Donación</label>
                            </div>
                        </div>

                        <!-- Clase de Donación -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select id="clase_donacion" name="clase_donacion" class="form-select" required>
                                    @foreach (App\Enums\TipoDonacion::cases() as $tipo)
                                        <option value="{{ $tipo->value }}"
                                            {{ $donacion->clase_donacion === $tipo->value ? 'selected' : '' }}>
                                            {{ $tipo->value }}
                                        </option>
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
                                        <option value="{{ $tipo->value }}"
                                            {{ $donacion->serologia === $tipo->value ? 'selected' : '' }}>
                                            {{ $tipo->value }}
                                        </option>
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
                                        <option value="{{ $tipo->value }}"
                                            {{ $donacion->anticuerpos_irregulares === $tipo->value ? 'selected' : '' }}>
                                            {{ $tipo->value }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="anticuerpos_irregulares">Anticuerpos Irregulares</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('donacion.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection