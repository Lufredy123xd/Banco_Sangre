@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Encabezado y botón de exportación -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><i class="fas fa-tint me-2"></i>Registro de Donaciones</h1>
            <a href="{{ route('donaciones.export.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i> Exportar PDF
            </a>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtrar Donaciones</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-end">
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
                            <i class="fas fa-broom me-2"></i> Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensajes de alerta -->
        @if (session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabla de donaciones -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Historial de Donaciones</h5>
                <span class="badge bg-primary">{{ $donaciones->total() }} registros</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tablaDonaciones">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Donante</th>
                                <th><i class="fas fa-calendar-day me-1"></i> Fecha</th>
                                <th><i class="fas fa-tag me-1"></i> Tipo</th>
                                <th><i class="fas fa-cog me-1"></i> Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDonaciones">
                            @include('donacion.partials.table', ['donaciones' => $donaciones])
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light">
                    <div id="paginacionDonaciones">
                        {{ $donaciones->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const btnLimpiar = document.getElementById('btnLimpiarFiltros');
            const tablaBody = document.querySelector('#tbodyDonaciones');

            // Función para cargar donaciones con AJAX
            function fetchDonaciones(page = 1) {
                const params = new URLSearchParams({
                    fecha_inicio: fechaInicio.value,
                    fecha_fin: fechaFin.value,
                    page: page
                });

                fetch(`/donacion/buscar?${params}`)
                    .then(response => response.json())
                    .then(data => {
                        tablaBody.innerHTML = data.tabla;
                        const paginacionDiv = document.getElementById('paginacionDonaciones');
                        if (paginacionDiv) {
                            paginacionDiv.innerHTML = data.paginacion;
                            attachPaginationEvents();
                        }
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

            // Manejar eventos de paginación
            function attachPaginationEvents() {
                const paginacionDiv = document.getElementById('paginacionDonaciones');
                if (!paginacionDiv) return;
                paginacionDiv.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(link.href);
                        const page = url.searchParams.get('page') || 1;
                        fetchDonaciones(page);
                    });
                });
            }

            // Inicializar eventos de paginación
            attachPaginationEvents();
        });
    </script>
@endsection