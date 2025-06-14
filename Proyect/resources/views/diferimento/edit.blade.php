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
                <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Diferimiento</h2>
            </div>
            <div class="card-body">
                <form action="{{ url('/diferimento/' . $diferimento->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Información del donante -->
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-user me-2"></i>Información del Donante</h5>
                        <hr class="mt-1">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input value="{{ $donante->nombre }} {{ $donante->apellido }}" 
                                           class="form-control" 
                                           id="donanteDisplay" 
                                           readonly>
                                    <label for="donanteDisplay">Donante</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del diferimiento -->
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-calendar-times me-2"></i>Detalles del Diferimiento</h5>
                        <hr class="mt-1">
                        <div class="row g-3">
                            <!-- Motivo -->
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control" 
                                           id="motivo" 
                                           name="motivo" 
                                           value="{{ $diferimento->motivo }}" 
                                           required>
                                    <label for="motivo">Motivo</label>
                                </div>
                            </div>

                            <!-- Fecha -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" 
                                           class="form-control" 
                                           id="fecha_diferimiento" 
                                           name="fecha_diferimiento" 
                                           value="{{ $diferimento->fecha_diferimiento }}" 
                                           required>
                                    <label for="fecha_diferimiento">Fecha de Diferimiento</label>
                                </div>
                            </div>

                            <!-- Tipo -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="tipo" 
                                            name="tipo" 
                                            class="form-select" 
                                            required
                                            onchange="toggleTiempoEnMeses()">
                                        <option value="Permanente" {{ $diferimento->tipo == 'Permanente' ? 'selected' : '' }}>Permanente</option>
                                        <option value="Temporal" {{ $diferimento->tipo == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                                    </select>
                                    <label for="tipo">Tipo de Diferimiento</label>
                                </div>
                            </div>

                            <!-- Tiempo en meses -->
                            <div class="col-md-6" id="tiempoEnMesesContainer" 
                                 style="{{ $diferimento->tipo == 'Permanente' ? 'display: none;' : '' }}">
                                <div class="form-floating">
                                    <input type="number" 
                                           class="form-control" 
                                           id="tiempo_en_meses" 
                                           name="tiempo_en_meses" 
                                           value="{{ $diferimento->tiempo_en_meses }}"
                                           {{ $diferimento->tipo == 'Temporal' ? 'required' : '' }}>
                                    <label for="tiempo_en_meses">Tiempo en Meses</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <a href="{{ route('diferimento.index') }}" class="btn btn-outline-secondary">
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

    <script>
        function toggleTiempoEnMeses() {
            const tipoDiferimiento = document.getElementById('tipo').value;
            const tiempoEnMesesContainer = document.getElementById('tiempoEnMesesContainer');
            const tiempoEnMesesInput = document.getElementById('tiempo_en_meses');

            if (tipoDiferimiento === 'Permanente') {
                tiempoEnMesesContainer.style.display = 'none';
                tiempoEnMesesInput.removeAttribute('required');
            } else {
                tiempoEnMesesContainer.style.display = 'block';
                tiempoEnMesesInput.setAttribute('required', 'required');
            }
        }
    </script>
@endsection