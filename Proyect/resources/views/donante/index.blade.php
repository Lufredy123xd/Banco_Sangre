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
                    @foreach (App\Enums\EstadoDonante::cases() as $estado)
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
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__abo" id="cmb__abo" class="form-select">
                    <option value="" selected>ABO</option>
                    @foreach (App\Enums\TipoABO::cases() as $abo)
                        <option value="{{ $abo->value }}">{{ $abo->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__rh" id="cmb__rh" class="form-select">
                    <option value="" selected>RH</option>
                    @foreach (App\Enums\TipoRH::cases() as $rh)
                        <option value="{{ $rh->value }}">{{ $rh->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <select name="cmb__ordenar" id="cmb__ordenar" class="form-select">
                    <option value="" selected>Ordenar por</option>
                    <option value="nombre">Nombre</option>
                    <option value="apellido">Apellido</option>
                    <option value="cedula">Cédula</option>
                    <option value="fecha">Última Fecha Donación</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__orden" id="cmb__orden" class="form-select">
                    <option value="asc" selected>Ascendente</option>
                    <option value="desc">Descendente</option>
                </select>
            </div>
        </div>

        <!-- Tabla de donantes -->
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="donantesTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>CI</th>
                                <th>ABO</th>
                                <th>RH</th>
                                <th>Última Fecha Donación</th>
                                <th>Sexo</th>
                                <th>Editar</th>
                                <th>Ver más</th>
                                <th>Gestionar donación</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donantes as $donante)
                                <tr class="fila-usuario">
                                    <td class="nombre">{{ $donante->nombre }}</td>
                                    <td class="apellido">{{ $donante->apellido }}</td>
                                    <td class="cedula">{{ $donante->cedula }}</td>
                                    <td class="abo">{{ $donante->ABO }}</td>
                                    <td class="rh">{{ $donante->RH }}</td>
                                    <td class="fecha">
                                        {{ $donante->donaciones->sortByDesc('fecha')->first() ? $donante->donaciones->sortByDesc('fecha')->first()->fecha : 'Sin donaciones' }}
                                    </td>
                                    <td class="sexo">{{ $donante->sexo }}</td>
                                    <td>
                                        <a href="{{ url('/donante/' . $donante->id . '/edit') }}"
                                            class="btn btn-sm btn-primary">
                                            <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar"
                                                style="width: 20px; height: 20px;">
                                        </a>
                                    </td>
                                    <!-- filepath: d:\Proyectos\_PHP\Banco_Sangre\Proyect\resources\views\donante\index.blade.php -->
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalDonacion" data-nombre="{{ $donante->nombre }}"
                                            data-apellido="{{ $donante->apellido }}" data-cedula="{{ $donante->cedula }}"
                                            data-abo="{{ $donante->ABO }}" data-rh="{{ $donante->RH }}"
                                            data-sexo="{{ $donante->sexo }}" data-estado="{{ $donante->estado }}"
                                            data-fecha="{{ $donante->donaciones->sortByDesc('fecha')->first() ? $donante->donaciones->sortByDesc('fecha')->first()->fecha : 'Sin donaciones' }}">
                                            <img src="{{ asset('imgs/ver_mas_icon.png') }}" alt="Ver más"
                                                style="width: 20px; height: 20px;">
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('gestionarDonante', ['id' => $donante->id]) }}"
                                            class="btn btn-sm btn-warning">
                                            <img src="{{ asset('imgs/gestionar_icon.png') }}" alt="Gestionar"
                                                style="width: 20px; height: 20px;">
                                        </a>
                                    </td>
                                    <td class="estado {{ strtolower(str_replace(' ', '-', $donante->estado)) }}">
                                        {{ $donante->estado }}</td>
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
                <a href="{{ route('donante.create') }}" class="btn btn-success">Registrar donante</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const estadoFilter = document.getElementById("cmb__estado");
            const sexoFilter = document.getElementById("cmb__sexo");
            const aboFilter = document.getElementById("cmb__abo");
            const rhFilter = document.getElementById("cmb__rh");
            const searchInput = document.getElementById("txt_buscar");
            const ordenarSelect = document.getElementById("cmb__ordenar");
            const ordenSelect = document.getElementById("cmb__orden");
            const rows = document.querySelectorAll(".fila-usuario");

            function filterTable() {
                const estadoValue = estadoFilter.value.toLowerCase();
                const sexoValue = sexoFilter.value.toLowerCase();
                const aboValue = aboFilter.value.toLowerCase();
                const rhValue = rhFilter.value.toLowerCase();
                const searchValue = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const estado = row.querySelector(".estado").textContent.toLowerCase();
                    const sexo = row.querySelector(".sexo").textContent.toLowerCase();
                    const abo = row.querySelector(".abo").textContent.toLowerCase();
                    const rh = row.querySelector(".rh").textContent.toLowerCase();
                    const nombre = row.querySelector(".nombre").textContent.toLowerCase();
                    const apellido = row.querySelector(".apellido").textContent.toLowerCase();
                    const cedula = row.querySelector(".cedula").textContent.toLowerCase();

                    const matchesEstado = !estadoValue || estado === estadoValue;
                    const matchesSexo = !sexoValue || sexo === sexoValue;
                    const matchesAbo = !aboValue || abo === aboValue;
                    const matchesRh = !rhValue || rh === rhValue;
                    const matchesSearch = !searchValue || nombre.includes(searchValue) || apellido.includes(
                        searchValue) || cedula.includes(searchValue);

                    if (matchesEstado && matchesSexo && matchesAbo && matchesRh && matchesSearch) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                });
            }

            function sortTable() {
                const column = ordenarSelect.value;
                const ascending = ordenSelect.value === "asc";
                const tbody = document.querySelector("#donantesTable tbody");
                const rowsArray = Array.from(rows);

                rowsArray.sort((a, b) => {
                    const aText = a.querySelector(`.${column}`).textContent.trim().toLowerCase();
                    const bText = b.querySelector(`.${column}`).textContent.trim().toLowerCase();

                    if (column === "fecha") {
                        return ascending ?
                            new Date(aText) - new Date(bText) :
                            new Date(bText) - new Date(aText);
                    }

                    return ascending ?
                        aText.localeCompare(bText) :
                        bText.localeCompare(aText);
                });

                rowsArray.forEach(row => tbody.appendChild(row));
            }

            estadoFilter.addEventListener("change", filterTable);
            sexoFilter.addEventListener("change", filterTable);
            aboFilter.addEventListener("change", filterTable);
            rhFilter.addEventListener("change", filterTable);
            searchInput.addEventListener("input", filterTable);
            ordenarSelect.addEventListener("change", sortTable);
            ordenSelect.addEventListener("change", sortTable);
        });
    </script>

<!-- filepath: d:\Proyectos\_PHP\Banco_Sangre\Proyect\resources\views\donante\index.blade.php -->
<div class="modal fade" id="modalDonacion" tabindex="-1" aria-labelledby="modalDonacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDonacionLabel">Detalle del Donante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> <span id="donanteNombre"></span></p>
                <p><strong>Apellido:</strong> <span id="donanteApellido"></span></p>
                <p><strong>Cédula:</strong> <span id="donanteCedula"></span></p>
                <p><strong>ABO:</strong> <span id="donanteAbo"></span></p>
                <p><strong>RH:</strong> <span id="donanteRh"></span></p>
                <p><strong>Sexo:</strong> <span id="donanteSexo"></span></p>
                <p><strong>Estado:</strong> <span id="donanteEstado"></span></p>
                <p><strong>Última Fecha de Donación:</strong> <span id="donanteFecha"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- filepath: d:\Proyectos\_PHP\Banco_Sangre\Proyect\resources\views\donante\index.blade.php -->
<script>
    const modalDonacion = document.getElementById('modalDonacion');
    modalDonacion.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const nombre = button.getAttribute('data-nombre');
        const apellido = button.getAttribute('data-apellido');
        const cedula = button.getAttribute('data-cedula');
        const abo = button.getAttribute('data-abo');
        const rh = button.getAttribute('data-rh');
        const sexo = button.getAttribute('data-sexo');
        const estado = button.getAttribute('data-estado');
        const fecha = button.getAttribute('data-fecha');

        modalDonacion.querySelector('#donanteNombre').textContent = nombre;
        modalDonacion.querySelector('#donanteApellido').textContent = apellido;
        modalDonacion.querySelector('#donanteCedula').textContent = cedula;
        modalDonacion.querySelector('#donanteAbo').textContent = abo;
        modalDonacion.querySelector('#donanteRh').textContent = rh;
        modalDonacion.querySelector('#donanteSexo').textContent = sexo;
        modalDonacion.querySelector('#donanteEstado').textContent = estado;
        modalDonacion.querySelector('#donanteFecha').textContent = fecha;
    });
</script>

@endsection
