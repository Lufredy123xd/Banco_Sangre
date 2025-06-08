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

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="btn-group">
                        <a href="{{ route('donantes.export.pdf') }}" class="btn btn-outline-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Exportar en PDF
                        </a>
                        <button id="btnImportarDonantes" class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-upload"></i> Importar CSV
                        </button>
                    </div>
                    <a href="{{ route('donante.create') }}" class="btn btn-success">
                        <i class="bi bi-person-plus"></i> Registrar donante
                    </a>
                </div>
            </div>
        </div>

        <div id="importarCsvDiv" style="display: none;">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('donante.importCsv') }}" method="POST" enctype="multipart/form-data"
                        class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-cloud-arrow-up"></i> Importar CSV
                            </button>
                        </div>
                    </form>
                    <a href="{{ asset('archivos-csv/Formato para subir donantes.csv') }}" class="btn btn-outline-success"
                        download="Formato_para_subir_donantes.csv">
                        <i class="bi bi-download"></i> Descargar formato de donantes
                    </a>
                </div>
            </div>
        </div>


        <!-- Tabla de donantes -->

        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="donantesTable" class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cédula</th>
                                <th>ABO</th>
                                <th>RH</th>
                                <th>Última Donación</th>
                                <th>Sexo</th>
                                <th>Editar</th>
                                <th>Ver más</th>
                                <th>Gestionar</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('donante.partials.tabla', ['donantes' => $donantes])
                        </tbody>
                    </table>


                    <div id="paginacionDonantes">
                        @include('donante.partials.paginacion', ['donantes' => $donantes])
                    </div>
                </div>

            </div>
        </div>

        <script>
            // Mostrar/ocultar el formulario de importar CSV
            document.addEventListener('DOMContentLoaded', function() {
                const btnImportar = document.getElementById('btnImportarDonantes');
                const importarDiv = document.getElementById('importarCsvDiv');
                btnImportar.addEventListener('click', function() {
                    importarDiv.style.display = importarDiv.style.display === 'none' ? 'block' : 'none';
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buscar = document.getElementById('txt_buscar');
                const estado = document.getElementById('cmb__estado');
                const sexo = document.getElementById('cmb__sexo');
                const abo = document.getElementById('cmb__abo');
                const rh = document.getElementById('cmb__rh');
                const ordenarPor = document.getElementById('cmb__ordenar');
                const orden = document.getElementById('cmb__orden');
                const tabla = document.querySelector('#donantesTable tbody');
                const paginacion = document.getElementById('paginacionDonantes');

                function fetchDonantes(url = null) {
                    let fetchUrl;

                    if (url) {
                        fetchUrl = url;
                    } else {
                        const params = new URLSearchParams({
                            search: buscar.value,
                            estado: estado.value,
                            sexo: sexo.value,
                            abo: abo.value,
                            rh: rh.value,
                            ordenar_por: ordenarPor.value,
                            orden: orden.value,
                        });
                        fetchUrl = `/donantes/buscar?${params.toString()}`;
                    }

                    fetch(fetchUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            tabla.innerHTML = data.tabla;
                            paginacion.innerHTML = data.paginacion;
                            asignarEventosPaginacion();
                        })
                        .catch(err => console.error('Error al buscar donantes:', err));
                }

                function asignarEventosPaginacion() {
                    const links = paginacion.querySelectorAll('a.page-link');
                    links.forEach(link => {
                        link.onclick = function(e) {
                            e.preventDefault();
                            fetchDonantes(this.href);
                        };
                    });
                }

                // Asignar eventos para que al cambiar los filtros haga la búsqueda
                [buscar, estado, sexo, abo, rh, ordenarPor, orden].forEach(el => {
                    el.addEventListener('input', () => fetchDonantes());
                    el.addEventListener('change', () => fetchDonantes());
                });

                // Carga inicial con AJAX para asignar eventos y mostrar datos correctos
                fetchDonantes();
            });
        </script>



        <!-- Modal para Ver Más -->
        <div class="modal fade" id="verMasModal" tabindex="-1" aria-labelledby="verMasModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white rounded-top">
                        <h5 class="modal-title" id="verMasModalLabel"><i class="bi bi-person-lines-fill me-2"></i>Detalles
                            del Donante</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light px-4 py-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><i
                                            class="bi bi-person-fill text-primary me-2"></i><strong>Nombre:</strong> <span
                                            id="detalleNombre"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-person-badge-fill text-primary me-2"></i><strong>Apellido:</strong>
                                        <span id="detalleApellido"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-credit-card-2-front-fill text-primary me-2"></i><strong>Cédula:</strong>
                                        <span id="detalleCedula"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-gender-ambiguous text-primary me-2"></i><strong>Sexo:</strong>
                                        <span id="detalleSexo"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-telephone-fill text-primary me-2"></i><strong>Teléfono:</strong>
                                        <span id="detalleTelefono"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-calendar-heart-fill text-primary me-2"></i><strong>Fecha de
                                            Nacimiento:</strong> <span id="detalleFechaNacimiento"></span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><i
                                            class="bi bi-droplet-half text-danger me-2"></i><strong>Grupo ABO:</strong>
                                        <span id="detalleABO"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-plus-slash-minus text-danger me-2"></i><strong>Factor RH:</strong>
                                        <span id="detalleRH"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-check-circle-fill text-success me-2"></i><strong>Estado:</strong>
                                        <span id="detalleEstado"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-chat-left-text-fill text-secondary me-2"></i><strong>Observaciones:</strong>
                                        <span id="detalleObservaciones"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-droplet-fill text-danger me-2"></i><strong>Donaciones:</strong>
                                        <span id="detalleDonaciones"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-x-circle-fill text-warning me-2"></i><strong>Diferimientos:</strong>
                                        <span id="detalleDiferimientos"></span></li>
                                    <li class="list-group-item"><i
                                            class="bi bi-pencil-fill text-info me-2"></i><strong>Modificado por:</strong>
                                        <span id="detalleModificadoPor"></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-white rounded-bottom">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        

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


                        document.getElementById('detalleModificadoPor').textContent = data.modificado_por || 'N/A';


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
