@extends('layouts.app')
@section('content')
    <div class="container-fluid py-4">
        <!-- Filtros y búsqueda -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4 mb-3">
                <input type="text" name="txt_buscar" id="txt_buscar" class="form-control shadow-sm"
                    placeholder="Ingrese dato a buscar">
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__estado" id="cmb__estado" class="form-select shadow-sm rounded-pill">
                    <option value="" selected>Estado</option>
                    @foreach (App\Enums\EstadoDonante::cases() as $estado)
                        <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__sexo" id="cmb__sexo" class="form-select shadow-sm rounded-pill">
                    <option value="" selected>Sexo</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__abo" id="cmb__abo" class="form-select shadow-sm rounded-pill">
                    <option value="" selected>ABO</option>
                    @foreach (App\Enums\TipoABO::cases() as $abo)
                        <option value="{{ $abo->value }}">{{ $abo->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__rh" id="cmb__rh" class="form-select shadow-sm rounded-pill">
                    <option value="" selected>RH</option>
                    @foreach (App\Enums\TipoRH::cases() as $rh)
                        <option value="{{ $rh->value }}">{{ $rh->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <select name="cmb__ordenar" id="cmb__ordenar" class="form-select shadow-sm rounded-pill">
                    <option value="" selected>Ordenar por</option>
                    <option value="nombre">Nombre</option>
                    <option value="apellido">Apellido</option>
                    <option value="fecha">Última Fecha Donación</option>
                </select>
            </div>
            <div class="col-md-6 col-lg-2 mb-3">
                <select name="cmb__orden" id="cmb__orden" class="form-select shadow-sm rounded-pill">
                    <option value="asc" selected>Ascendente</option>
                    <option value="desc">Descendente</option>
                </select>
            </div>
        </div>
        <!-- Botón registrar -->

        <div class="d-flex justify-content-between">
            <a href="{{ route('donantes.export.pdf') }}" class="btn btn-danger mb-3">Exportar en PDF</a>
            <a href="{{ route('donante.create') }}" class="btn btn-success mb-3">Registrar donante</a>
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
                                        {{ $donante->donaciones->sortByDesc('fecha')->first() ? \Carbon\Carbon::parse($donante->donaciones->sortByDesc('fecha')->first()->fecha)->format('d/m/Y') : 'Sin donaciones' }}
                                    </td>
                                    <td class="sexo">{{ $donante->sexo }}</td>
                                    <td>
                                        <a href="{{ url('/donante/' . $donante->id . '/edit') }}"
                                            class="btn btn-sm btn-primary">
                                            <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar"
                                                style="width: 20px; height: 20px;">
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="verMas({{ $donante->id }})"
                                            data-bs-toggle="modal" data-bs-target="#verMasModal">
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


    </div>

    <!-- Modal para Ver Más -->
    <div class="modal fade" id="verMasModal" tabindex="-1" aria-labelledby="verMasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verMasModalLabel">Detalles del Donante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="detalleNombre"></span></p>
                    <p><strong>Apellido:</strong> <span id="detalleApellido"></span></p>
                    <p><strong>Cédula:</strong> <span id="detalleCedula"></span></p>
                    <p><strong>Sexo:</strong> <span id="detalleSexo"></span></p>
                    <p><strong>Teléfono:</strong> <span id="detalleTelefono"></span></p>
                    <p><strong>Fecha de Nacimiento:</strong> <span id="detalleFechaNacimiento"></span></p>
                    <p><strong>Grupo Sanguíneo (ABO):</strong> <span id="detalleABO"></span></p>
                    <p><strong>Factor RH:</strong> <span id="detalleRH"></span></p>
                    <p><strong>Estado:</strong> <span id="detalleEstado"></span></p>
                    <p><strong>Observaciones:</strong> <span id="detalleObservaciones"></span></p>
                    <p><strong>Cantidad de Donaciones:</strong> <span id="detalleDonaciones"></span></p>
                    <p><strong>Cantidad de Diferimientos:</strong> <span id="detalleDiferimientos"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
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
                const estadoValue = estadoFilter.value.toLowerCase().trim();
                const sexoValue = sexoFilter.value.toLowerCase().trim();
                const aboValue = aboFilter.value.toLowerCase().trim();
                const rhValue = rhFilter.value.toLowerCase().trim();
                const searchValue = searchInput.value.toLowerCase().trim();

                rows.forEach(row => {
                    const estado = row.querySelector(".estado").textContent.toLowerCase().trim();
                    const sexo = row.querySelector(".sexo").textContent.toLowerCase().trim();
                    const abo = row.querySelector(".abo").textContent.toLowerCase().trim();
                    const rh = row.querySelector(".rh").textContent.toLowerCase().trim();
                    const nombre = row.querySelector(".nombre").textContent.toLowerCase().trim();
                    const apellido = row.querySelector(".apellido").textContent.toLowerCase().trim();
                    const cedula = row.querySelector(".cedula").textContent.toLowerCase().trim();

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
                        const parseDate = (text) => {
                            const date = new Date(text);
                            return isNaN(date) ? new Date(0) : date;
                        };

                        const aDate = parseDate(aText);
                        const bDate = parseDate(bText);

                        return ascending ? aDate - bDate : bDate - aDate;
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

    <script>
        function verMas(donanteId) {
            // Realiza una solicitud AJAX para obtener los detalles del donante
            fetch(`/donante/${donanteId}`)
                .then(response => response.json())
                .then(data => {
                    // Rellena los datos en el modal
                    document.getElementById('detalleNombre').textContent = data.nombre;
                    document.getElementById('detalleApellido').textContent = data.apellido;
                    document.getElementById('detalleCedula').textContent = data.cedula;
                    document.getElementById('detalleSexo').textContent = data.sexo === 'M' ? 'Masculino' : 'Femenino';
                    document.getElementById('detalleTelefono').textContent = data.telefono;
                    document.getElementById('detalleFechaNacimiento').textContent = data.fecha_nacimiento;
                    document.getElementById('detalleABO').textContent = data.ABO;
                    document.getElementById('detalleRH').textContent = data.RH;
                    document.getElementById('detalleEstado').textContent = data.estado;
                    document.getElementById('detalleObservaciones').textContent = data.observaciones ||
                        'Sin observaciones';
                    document.getElementById('detalleDonaciones').textContent = data.donaciones_count || 0;
                    document.getElementById('detalleDiferimientos').textContent = data.diferimientos_count || 0;

                    // Muestra el modal
                    const modal = new bootstrap.Modal(document.getElementById('verMasModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error al obtener los detalles del donante:', error);
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const modalElement = document.getElementById('verMasModal');

            modalElement.addEventListener('hidden.bs.modal', function() {
                // Forzar la eliminación del backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }

                // Asegúrate de que el body no tenga la clase 'modal-open'
                document.body.classList.remove('modal-open');
                document.body.style.overflow = ''; // Restablece el scroll
            });
        });
    </script>
@endsection
