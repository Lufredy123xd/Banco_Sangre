@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="filtroFecha" class="form-label">Filtrar por:</label>
                        <select id="filtroFecha" class="form-select">
                            <option value="todas">Todas</option>
                            <option value="hoy">Hoy</option>
                            <option value="semana">Esta semana</option>
                        </select>
                    </div>
                    <div class="col-md-8 text-md-end">
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
                        <tbody>
                            @foreach ($donaciones as $donacion)
                                <tr class="fila-donacion">
                                    <td>{{ $donacion->donante->nombre }} {{ $donacion->donante->apellido }}</td>
                                    <td class="fecha-donacion">
                                        {{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $donacion->clase_donacion }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ url('/donacion/' . $donacion->id . '/edit') }}"
                                                class="btn btn-primary btn-sm"><img src="{{ asset('imgs/edit_icon.png') }}"
                                                    alt="Editar" style="width: 20px; height: 20px;"></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
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
        document.getElementById('filtroFecha').addEventListener('change', function() {
            const filtro = this.value;
            const filas = document.querySelectorAll('#tablaDonaciones tbody tr');
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            const primerDiaSemana = new Date(hoy);
            primerDiaSemana.setDate(hoy.getDate() - hoy.getDay());
            primerDiaSemana.setHours(0, 0, 0, 0);
            const ultimoDiaSemana = new Date(primerDiaSemana);
            ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6);
            ultimoDiaSemana.setHours(23, 59, 59, 999);

            filas.forEach(fila => {
                const fechaTexto = fila.querySelector('.fecha-donacion').textContent.trim();
                const partes = fechaTexto.split('/');
                const fecha = new Date(partes[2], partes[1] - 1, partes[0]);
                fecha.setHours(0, 0, 0, 0);

                let mostrar = true;
                if (filtro === 'hoy') {
                    mostrar = fecha.getTime() === hoy.getTime();
                } else if (filtro === 'semana') {
                    mostrar = fecha >= primerDiaSemana && fecha <= ultimoDiaSemana;
                }

                fila.style.display = mostrar ? '' : 'none';
            });
        });
    </script>
@endsection
