@extends('layouts.app')
@section('content')

<div class="container-fluid py-4">
    <!-- Filtros y búsqueda -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-4 mb-3">
            <input type="text" name="txt_buscar" id="txt_buscar" class="form-control" placeholder="Ingrese dato a buscar">
        </div>
        <div class="col-md-6 col-lg-2 mb-3">
            <select name="cmb__estado" id="cmb__estado" class="form-select">
                <option value="" selected>Estado</option>
                @foreach (App\Enums\EstadoUsuario::cases() as $estado)
                <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 col-lg-2 mb-3">
            <select name="cmb__sexo" id="cmb__sexo" class="form-select">
                <option value="" selected>Sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <select name="cmb__ordenar" id="cmb__ordenar" class="form-select">
                <option value="" selected>Ordenar por</option>
                <option value="nombre">Nombre</option>
                <option value="apellido">Apellido</option>
                <option value="cedula">Cédula</option>
                <option value="tipo_usuario">Tipo de Usuario</option>
            </select>
        </div>
        <div class="col-md-6 col-lg-2 mb-3">
            <select name="cmb__orden" id="cmb__orden" class="form-select">
                <option value="asc" selected>Ascendente</option>
                <option value="desc">Descendente</option>
            </select>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="usuariosTable" class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>CI</th>
                            <th>Tipo de Usuario</th>
                            <th>Curso hemoterapia</th>
                            <th>Editar</th>
                            <th>Ver más</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr class="fila-usuario">
                            <td class="nombre">{{ $usuario->nombre }}</td>
                            <td class="apellido">{{ $usuario->apellido }}</td>
                            <td class="cedula">{{ $usuario->cedula }}</td>
                            <td class="tipo_usuario">{{ $usuario->tipo_usuario }}</td>
                            <td class="sexo">{{ $usuario->curso_hemoterapia }}</td>
                            <td>
                                <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}" class="btn btn-sm btn-primary">
                                    <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar" style="width: 20px; height: 20px;">
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <img src="{{ asset('imgs/ver_mas_icon.png') }}" alt="Ver más" style="width: 20px; height: 20px;">
                                </a>
                            </td>

                            <td class="estado {{ strtolower(str_replace(' ', '-', $usuario->estado)) }}">{{ $usuario->estado }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botón registrar -->
    <div class="row mt-4">
    <div class="col-12 text-end d-flex justify-content-around">
    @if (session('tipo_usuario') === 'Administrador')
        <a href="{{ route('donante.index') }}" class="btn btn-dark">Gestionar donante</a>
        <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Gestionar usuario</a>
    
    @endif
    <a href="{{ route('usuario.create') }}" class="btn btn-success">Registrar usuario</a>
</div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const estadoFilter = document.getElementById("cmb__estado");
        const sexoFilter = document.getElementById("cmb__sexo");
        const searchInput = document.getElementById("txt_buscar");
        const ordenarSelect = document.getElementById("cmb__ordenar");
        const ordenSelect = document.getElementById("cmb__orden");
        const rows = document.querySelectorAll(".fila-usuario");

        function filterTable() {
            const estadoValue = estadoFilter.value.toLowerCase();
            const sexoValue = sexoFilter.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const estado = row.querySelector(".estado").textContent.toLowerCase();
                const sexo = row.querySelector(".sexo").textContent.toLowerCase();
                const nombre = row.querySelector(".nombre").textContent.toLowerCase();
                const apellido = row.querySelector(".apellido").textContent.toLowerCase();
                const cedula = row.querySelector(".cedula").textContent.toLowerCase();

                const matchesEstado = !estadoValue || estado === estadoValue;
                const matchesSexo = !sexoValue || sexo === sexoValue;
                const matchesSearch = !searchValue || nombre.includes(searchValue) || apellido.includes(searchValue) || cedula.includes(searchValue);

                if (matchesEstado && matchesSexo && matchesSearch) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function sortTable() {
            const column = ordenarSelect.value;
            const ascending = ordenSelect.value === "asc";
            const tbody = document.querySelector("#usuariosTable tbody");
            const rowsArray = Array.from(rows);

            rowsArray.sort((a, b) => {
                const aText = a.querySelector(`.${column}`).textContent.trim().toLowerCase();
                const bText = b.querySelector(`.${column}`).textContent.trim().toLowerCase();

                return ascending ?
                    aText.localeCompare(bText) :
                    bText.localeCompare(aText);
            });

            rowsArray.forEach(row => tbody.appendChild(row));
        }

        estadoFilter.addEventListener("change", filterTable);
        sexoFilter.addEventListener("change", filterTable);
        searchInput.addEventListener("input", filterTable);
        ordenarSelect.addEventListener("change", sortTable);
        ordenSelect.addEventListener("change", sortTable);
    });
</script>
@endsection