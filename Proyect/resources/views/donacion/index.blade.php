@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Donaciones</h1>

        <!-- Filtro por rango de fechas -->
        <div class="mb-3">
            <label for="filtroFecha" class="form-label">Filtrar por:</label>
            <select id="filtroFecha" class="form-select" style="width:auto;display:inline-block;">
                <option value="todas">Todas</option>
                <option value="hoy">Hoy</option>
                <option value="semana">Esta semana</option>
            </select>
        </div>

        <table class="table table-striped table-bordered" id="tablaDonaciones">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Donante</th>
                    <th>Fecha</th>
                    <th>Clase de Donación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donaciones as $donacion)
                    <tr>
                        <td>{{ $donacion->id }}</td>
                        <td>{{ $donacion->donante->nombre }} {{ $donacion->donante->apellido }}</td>
                        <td class="fecha-donacion">{{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $donacion->clase_donacion }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/donacion/' . $donacion->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ url('/donacion/' . $donacion->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta donación?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <script>
    document.getElementById('filtroFecha').addEventListener('change', function() {
        const filtro = this.value;
        const filas = document.querySelectorAll('#tablaDonaciones tbody tr');
        const hoy = new Date();
        hoy.setHours(0,0,0,0);

        // Calcular el primer y último día de la semana (lunes a domingo)
        const primerDiaSemana = new Date(hoy);
        primerDiaSemana.setDate(hoy.getDate() - hoy.getDay());
        primerDiaSemana.setHours(0,0,0,0);
        const ultimoDiaSemana = new Date(primerDiaSemana);
        ultimoDiaSemana.setDate(primerDiaSemana.getDate() + 6);
        ultimoDiaSemana.setHours(23,59,59,999);

        filas.forEach(fila => {
            const fechaTexto = fila.querySelector('.fecha-donacion').textContent.trim();
            // Convertir 'dd/mm/aaaa' a Date correctamente
            const partes = fechaTexto.split('/');
            const fecha = new Date(partes[2], partes[1] - 1, partes[0]);
            fecha.setHours(0,0,0,0);

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