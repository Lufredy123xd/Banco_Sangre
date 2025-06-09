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
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                            <input type="text" name="txt_buscar" id="txt_buscar" class="form-control shadow-sm"
                                placeholder="Buscar por nombre, apellido o cédula">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-info-circle"></i></span>
                            <select name="cmb__estado" id="cmb__estado" class="form-select shadow-sm">
                                <option value="" selected>Estado</option>
                                @foreach (App\Enums\EstadoDonante::cases() as $estado)
                                    <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-venus-mars"></i></span>
                            <select name="cmb__sexo" id="cmb__sexo" class="form-select shadow-sm">
                                <option value="" selected>Sexo</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-tint"></i></span>
                            <select name="cmb__abo" id="cmb__abo" class="form-select shadow-sm">
                                <option value="" selected>ABO</option>
                                @foreach (App\Enums\TipoABO::cases() as $abo)
                                    <option value="{{ $abo->value }}">{{ $abo->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-tint"></i></span>
                            <select name="cmb__rh" id="cmb__rh" class="form-select shadow-sm">
                                <option value="" selected>RH</option>
                                @foreach (App\Enums\TipoRH::cases() as $rh)
                                    <option value="{{ $rh->value }}">{{ $rh->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-sort"></i></span>
                            <select name="cmb__ordenar" id="cmb__ordenar" class="form-select shadow-sm">
                                <option value="" selected>Ordenar por</option>
                                <option value="nombre">Nombre</option>
                                <option value="apellido">Apellido</option>
                                <option value="fecha">Última Donación</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-sort-alpha-down"></i></span>
                            <select name="cmb__orden" id="cmb__orden" class="form-select shadow-sm">
                                <option value="asc" selected>Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="btn-group">
                        <a href="{{ route('donantes.export.pdf') }}" class="btn btn-outline-danger">
                            <i class="fas fa-file-pdf me-2"></i> Exportar PDF
                        </a>
                        <button id="btnImportarDonantes" class="btn btn-outline-primary" type="button">
                            <i class="fas fa-file-import me-2"></i> Importar CSV
                        </button>
                        <a href="{{ asset('archivos-csv/Formato para subir donantes.csv') }}"
                            class="btn btn-outline-success" download="Formato_para_subir_donantes.csv">
                            <i class="fas fa-file-download me-2"></i> Formato CSV
                        </a>
                    </div>
                    <a href="{{ route('donante.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i> Nuevo Donante
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario de Importación (oculto inicialmente) -->
        <div id="importarCsvDiv" class="card shadow-sm mb-4" style="display: none;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-import me-2"></i>Importar Donantes desde CSV</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('donante.importCsv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-2"></i> Subir Archivo
                        </button>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Asegúrese de que el archivo CSV siga el formato correcto.
                    </div>
                </form>
            </div>
        </div>

        <!-- Mensajes de sesión -->
        @if (session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabla de donantes -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Listado de Donantes</h5>
                
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="donantesTable" class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Nombre</th>
                                <th><i class="fas fa-user me-1"></i> Apellido</th>
                                <th><i class="fas fa-id-card me-1"></i> Cédula</th>
                                <th><i class="fas fa-tint me-1"></i> ABO</th>
                                <th><i class="fas fa-tint me-1"></i> RH</th>
                                <th><i class="fas fa-calendar-alt me-1"></i> Última Donación</th>
                                <th><i class="fas fa-venus-mars me-1"></i> Sexo</th>
                                <th><i class="fas fa-info-circle me-1"></i> Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('donante.partials.tabla', ['donantes' => $donantes])
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light">
                    <div id="paginacionDonantes">
                        @include('donante.partials.paginacion', ['donantes' => $donantes])
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Ver Más -->
        <div class="modal fade" id="verMasModal" tabindex="-1" aria-labelledby="verMasModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="verMasModalLabel">
                            <i class="fas fa-user-circle me-2"></i>Detalles del Donante
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>Información Personal</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-user me-2 text-primary"></i>Nombre:</strong> <span
                                                    id="detalleNombre" class="float-end"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-user me-2 text-primary"></i>Apellido:</strong> <span
                                                    id="detalleApellido" class="float-end"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-id-card me-2 text-primary"></i>Cédula:</strong> <span
                                                    id="detalleCedula" class="float-end"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-venus-mars me-2 text-primary"></i>Sexo:</strong>
                                                <span id="detalleSexo" class="float-end"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-phone me-2 text-primary"></i>Teléfono:</strong> <span
                                                    id="detalleTelefono" class="float-end"></span></li>
                                            <li><strong><i class="fas fa-birthday-cake me-2 text-primary"></i>Fecha
                                                    Nacimiento:</strong> <span id="detalleFechaNacimiento"
                                                    class="float-end"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-tint me-2"></i>Información Médica</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><strong><i class="fas fa-tint me-2 text-danger"></i>Grupo
                                                    ABO:</strong> <span id="detalleABO"
                                                    class="float-end badge bg-danger text-white"></span></li>
                                            <li class="mb-2"><strong><i class="fas fa-tint me-2 text-danger"></i>Factor
                                                    RH:</strong> <span id="detalleRH"
                                                    class="float-end badge bg-danger text-white"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-info-circle me-2 text-success"></i>Estado:</strong>
                                                <span id="detalleEstado" class="float-end"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-comment me-2 text-secondary"></i>Observaciones:</strong>
                                                <span id="detalleObservaciones" class="float-end"></span></li>
                                            <li class="mb-2"><strong><i
                                                        class="fas fa-history me-2 text-info"></i>Modificado por:</strong>
                                                <span id="detalleModificadoPor" class="float-end"></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Estadísticas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="p-2 bg-info bg-opacity-10 rounded">
                                                    <h3 class="text-info mb-0" id="detalleDonaciones">0</h3>
                                                    <small class="text-muted">Donaciones</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-2 bg-warning bg-opacity-10 rounded">
                                                    <h3 class="text-warning mb-0" id="detalleDiferimientos">0</h3>
                                                    <small class="text-muted">Diferimientos</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cerrar
                        </button>
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

                // Configurar filtros AJAX
                const buscar = document.getElementById('txt_buscar');
                const estado = document.getElementById('cmb__estado');
                const sexo = document.getElementById('cmb__sexo');
                const abo = document.getElementById('cmb__abo');
                const rh = document.getElementById('cmb__rh');
                const ordenarPor = document.getElementById('cmb__ordenar');
                const orden = document.getElementById('cmb__orden');
                const tabla = document.querySelector('#donantesTable tbody');
                const paginacion = document.getElementById('paginacionDonantes');
                const contador = document.getElementById('contadorDonantes');

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
                            contador.textContent = `${data.total} registros`;
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

            function verMas(donanteId) {
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

                        // Obtiene o crea la instancia del modal y lo muestra
                        const modalEl = document.getElementById('verMasModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();

                        // Asegura que se elimine el backdrop al cerrar
                        modalEl.addEventListener('hidden.bs.modal', () => {
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                                document.body.classList.remove('modal-open');
                                document.body.style = ''; // Limpia estilos inline como overflow:hidden
                            }
                        }, {
                            once: true
                        }); // Solo una vez por apertura
                    })
                    .catch(error => {
                        console.error('Error al obtener los detalles del donante:', error);
                    });
            }
        </script>
    </div>
@endsection
