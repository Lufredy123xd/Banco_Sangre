@extends('layouts.app')
@section('content')
    <div class="container-fluid py-4">
        <!-- Filtros y búsqueda -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4 mb-3">
                <input type="text" name="txt_buscar" id="txt_buscar" class="form-control" placeholder="Ingrese dato a buscar">
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <select name="cmb__ordenar" id="cmb__ordenar" class="form-select">
                    <option value="" selected>Ordenar por</option>
                    <option value="nombre">Nombre</option>
                    <option value="apellido">Apellido</option>
                    <option value="tipo_usuario">Tipo de Usuario</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__orden" id="cmb__orden" class="form-select">
                    <option value="asc" selected>Ascendente</option>
                    <option value="desc">Descendente</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__estado" id="cmb__estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                    <option value="Suspendido">Suspendido</option>
                </select>
            </div>
        </div>
        <!-- Botón registrar -->
        <div class="row mt-4">
            <div class="col-12 text-end d-flex justify-content-end">
                <a href="{{ route('usuario.create') }}" class="btn btn-success">Registrar usuario</a>
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
                                    <td class="curso_hemoterapia">{{ $usuario->curso_hemoterapia }}</td>
                                    <td>
                                        <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}"
                                            class="btn btn-sm btn-primary">
                                            <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar"
                                                style="width: 20px; height: 20px;">
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalUsuario" data-nombre="{{ $usuario->nombre }}"
                                            data-apellido="{{ $usuario->apellido }}" data-cedula="{{ $usuario->cedula }}"
                                            data-tipo_usuario="{{ $usuario->tipo_usuario }}"
                                            data-curso_hemoterapia="{{ $usuario->curso_hemoterapia }}"
                                            data-estado="{{ $usuario->estado }}">
                                            <img src="{{ asset('imgs/ver_mas_icon.png') }}" alt="Ver más"
                                                style="width: 20px; height: 20px;">
                                        </button>
                                    </td>

                                    <td class="estado {{ strtolower(str_replace(' ', '-', $usuario->estado)) }}">
                                        {{ $usuario->estado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const estadoFilter = document.getElementById("cmb__estado");
            const searchInput = document.getElementById("txt_buscar");
            const ordenarSelect = document.getElementById("cmb__ordenar");
            const ordenSelect = document.getElementById("cmb__orden");
            const rows = document.querySelectorAll(".fila-usuario");

            function filterTable() {
                const estadoValue = estadoFilter ? estadoFilter.value.trim().toLowerCase() : "";
                const searchValue = searchInput.value.trim().toLowerCase();

                rows.forEach(row => {
                    const estado = row.querySelector(".estado").textContent.trim().toLowerCase();
                    const nombre = row.querySelector(".nombre").textContent.trim().toLowerCase();
                    const apellido = row.querySelector(".apellido").textContent.trim().toLowerCase();
                    const cedula = row.querySelector(".cedula").textContent.trim().toLowerCase();

                    const matchesEstado = !estadoValue || estado === estadoValue;
                    const matchesSearch = !searchValue || nombre.includes(searchValue) || apellido.includes(searchValue) || cedula.includes(searchValue);

                    if (matchesEstado && matchesSearch) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            function sortTable() {
                const column = ordenarSelect.value;
                if (!column) return;
                const ascending = ordenSelect.value === "asc";
                const tbody = document.querySelector("#usuariosTable tbody");
                const rowsArray = Array.from(rows);

                rowsArray.sort((a, b) => {
                    const aText = a.querySelector(`.${column}`).textContent.trim().toLowerCase();
                    const bText = b.querySelector(`.${column}`).textContent.trim().toLowerCase();
                    return ascending ? aText.localeCompare(bText) : bText.localeCompare(aText);
                });

                rowsArray.forEach(row => tbody.appendChild(row));
            }

            if (estadoFilter) estadoFilter.addEventListener("change", filterTable);
            searchInput.addEventListener("input", filterTable);
            ordenarSelect.addEventListener("change", sortTable);
            ordenSelect.addEventListener("change", sortTable);
        });
    </script>

    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioLabel">Detalle del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="usuarioNombre"></span></p>
                    <p><strong>Apellido:</strong> <span id="usuarioApellido"></span></p>
                    <p><strong>Cédula:</strong> <span id="usuarioCedula"></span></p>
                    <p><strong>Tipo de Usuario:</strong> <span id="usuarioTipo"></span></p>
                    <p><strong>Curso Hemoterapia:</strong> <span id="usuarioCurso"></span></p>
                    <p><strong>Estado:</strong> <span id="usuarioEstado"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modalUsuario = document.getElementById('modalUsuario');
        modalUsuario.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const nombre = button.getAttribute('data-nombre');
            const apellido = button.getAttribute('data-apellido');
            const cedula = button.getAttribute('data-cedula');
            const tipoUsuario = button.getAttribute('data-tipo_usuario');
            const cursoHemoterapia = button.getAttribute('data-curso_hemoterapia');
            const estado = button.getAttribute('data-estado');

            modalUsuario.querySelector('#usuarioNombre').textContent = nombre;
            modalUsuario.querySelector('#usuarioApellido').textContent = apellido;
            modalUsuario.querySelector('#usuarioCedula').textContent = cedula;
            modalUsuario.querySelector('#usuarioTipo').textContent = tipoUsuario;
            modalUsuario.querySelector('#usuarioCurso').textContent = cursoHemoterapia;
            modalUsuario.querySelector('#usuarioEstado').textContent = estado;
        });
    </script>
@endsection
