@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="fecha_inicio">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin">Fecha fin</label>
                        <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin">
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('donaciones.export.pdf') }}" class="btn btn-outline-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Exportar en PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabla -->
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablaDonaciones">
                        <thead class="table-dark">
                            <tr>
                                <th>Donante</th>
                                <th>Fecha</th>
                                <th>Clase de Donación</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDonaciones">
                            @include('donacion.partials.table', ['donaciones' => $donaciones])
                        </tbody>
                    </table>
                    <div id="paginacionDonaciones">
                        {{ $donaciones->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensaje -->
        @if (session('mensaje'))
            <div class="alert alert-success mt-3">
                {{ session('mensaje') }}
            </div>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const tablaBody = document.querySelector('#tbodyDonaciones');

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

            fechaInicio.addEventListener('input', () => fetchDonaciones());
            fechaFin.addEventListener('input', () => fetchDonaciones());

            attachPaginationEvents();
        });
    </script>
@endsection
