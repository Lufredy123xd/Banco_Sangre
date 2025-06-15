@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Estadísticas</h1>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" id="fecha_inicio" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" id="fecha_fin" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button id="btnLimpiarFiltros" class="btn btn-outline-secondary">
                            <i class="fas fa-broom me-2"></i>Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="estadisticasContainer">
            @include('estadisticas.partials.table', ['solidarios' => $solidarios, 'voluntarios' => $voluntarios, 'donacionesAgendadas' => $donacionesAgendadas, 'diferimientosAgendados' => $diferimientosAgendados, 'noAsistio' => $noAsistio, 'temporales' => $temporales, 'permanentes' => $permanentes])
        </div>
    </div>
    <script>
        let graficoDonaciones, graficoAgendados, graficoDiferimientos;
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const btnLimpiar = document.getElementById('btnLimpiarFiltros');
            const tablaBody = document.querySelector('#estadisticasContainer');

            // Función para cargar donaciones con AJAX
            function fetchDonaciones() {
                const params = new URLSearchParams({
                    fecha_inicio: fechaInicio.value,
                    fecha_fin: fechaFin.value,
                });

                fetch(`/estadisticas/buscar?${params}`)
                    .then(response => response.json())
                    .then(data => {
                        tablaBody.innerHTML = data.tabla;
                        // Actualizar gráficos con los nuevos datos
                        actualizarGraficos(data.datos);
                    })
                    .catch(err => console.error('Error en la búsqueda:', err));
            }

            // Limpiar filtros
            btnLimpiar.addEventListener('click', function() {
                fechaInicio.value = '';
                fechaFin.value = '';
                fetchDonaciones();
            });

            // Eventos para los filtros
            fechaInicio.addEventListener('change', () => fetchDonaciones());
            fechaFin.addEventListener('change', () => fetchDonaciones());
        });

        
    </script>
@endsection
