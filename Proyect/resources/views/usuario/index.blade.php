@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Filtros y búsqueda -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                            <input type="text" name="txt_buscar" id="txt_buscar" class="form-control"
                                placeholder="Buscar por nombre, apellido o cédula">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-sort"></i></span>
                            <select name="cmb__ordenar" id="cmb__ordenar" class="form-select">
                                <option value="" selected>Ordenar por</option>
                                <option value="nombre">Nombre</option>
                                <option value="apellido">Apellido</option>
                                <option value="tipo_usuario">Tipo de Usuario</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-sort-alpha-down"></i></span>
                            <select name="cmb__orden" id="cmb__orden" class="form-select">
                                <option value="asc" selected>Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-info-circle"></i></span>
                            <select name="cmb__estado" id="cmb__estado" class="form-select">
                                <option value="">Todos los estados</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Encabezado y botón de registro -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Gestión de Usuarios</h5>
                    <a href="{{ route('usuario.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i> Registrar Usuario
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Listado de Usuarios</h5>
                <span class="badge bg-primary">{{ $usuarios->total() }} registros</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="usuariosTable" class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Nombre</th>
                                <th><i class="fas fa-user me-1"></i> Apellido</th>
                                <th><i class="fas fa-id-card me-1"></i> Cédula</th>
                                <th><i class="fas fa-user-tag me-1"></i> Tipo</th>
                                <th><i class="fas fa-certificate me-1"></i> Curso Hemoterapia</th>
                                <th><i class="fas fa-cog me-1"></i> Acciones</th>
                                <th><i class="fas fa-circle me-1"></i> Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->nombre }}</td>
                                    <td>{{ $usuario->apellido }}</td>
                                    <td>{{ $usuario->cedula }}</td>
                                    <td>{{ $usuario->tipo_usuario }}</td>
                                    <td>
                                        @php
                                            $cursoClass =
                                                [
                                                    'Hemoterapia I' => 'bg-success',
                                                    'Hemoterapia II' => 'bg-warning',
                                                    'Hemoterapia III' => 'bg-secondary',
                                                    'Hemoterapia IV' => 'bg-danger',
                                                    'No Aplica' => 'bg-info',
                                                ][$usuario->curso_hemoterapia] ?? 'bg-light text-dark';

                                        @endphp
                                        <span class="badge {{ $cursoClass }}">
                                            
                                            {{ $usuario->curso_hemoterapia ?: 'No especificado' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}"
                                                class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $estadoClass =
                                                [
                                                    'Activo' => 'bg-success',
                                                    'Inactivo' => 'bg-secondary',
                                                    'Suspendido' => 'bg-warning',
                                                ][$usuario->estado] ?? 'bg-light text-dark';
                                        @endphp
                                        <span class="badge {{ $estadoClass }}">{{ $usuario->estado }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light">
                    {{ $usuarios->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const txtBuscar = document.getElementById('txt_buscar');
            const cmbOrdenar = document.getElementById('cmb__ordenar');
            const cmbOrden = document.getElementById('cmb__orden');
            const cmbEstado = document.getElementById('cmb__estado');
            const tableBody = document.querySelector('#usuariosTable tbody');

            function fetchUsuarios() {
                const params = new URLSearchParams({
                    busqueda_general: txtBuscar.value,
                    ordenar_por: cmbOrdenar.value,
                    orden: cmbOrden.value,
                    estado: cmbEstado.value
                });

                fetch(`/usuarios/buscar?${params}`)
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                    })
                    .catch(err => console.error('Error en la búsqueda:', err));
            }

            txtBuscar.addEventListener('input', fetchUsuarios);
            cmbOrdenar.addEventListener('change', fetchUsuarios);
            cmbOrden.addEventListener('change', fetchUsuarios);
            cmbEstado.addEventListener('change', fetchUsuarios);
        });

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

            const cursoBadge = cursoHemoterapia ?
                '<span class="badge bg-success">Completado</span>' :
                '<span class="badge bg-secondary">Pendiente</span>';
            modalUsuario.querySelector('#usuarioCurso').innerHTML = cursoBadge;

            const estadoClass = {
                'Activo': 'bg-success',
                'Inactivo': 'bg-secondary',
                'Suspendido': 'bg-warning'
            } [estado] || 'bg-light text-dark';

            modalUsuario.querySelector('#usuarioEstado').innerHTML =
                `<span class="badge ${estadoClass}">${estado}</span>`;
        });
    </script>
@endsection
