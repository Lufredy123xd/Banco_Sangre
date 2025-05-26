@extends('layouts.app')

@section('content')
    <div class="content__main">

        <div class="content__main">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>CI</th>
                            <th>ABO</th>
                            <th>RH</th>
                            <th>Última Fecha Donación</th>
                            <th>Fecha agendada | Hora</th>
                            <th>Sexo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="fila-usuario">
                            <td>{{ $donante->nombre }}</td>
                            <td>{{ $donante->apellido }}</td>
                            <td>{{ $donante->cedula }}</td>
                            <td>{{ $donante->ABO }}</td>
                            <td>{{ $donante->RH }}</td>
                            <td>{{ $donante->donaciones->sortByDesc('fecha')->first() ? \Carbon\Carbon::parse($donante->donaciones->sortByDesc('fecha')->first()->fecha)->format('d/m/Y') : 'Sin donaciones' }}
                            </td>
                            <td>
                                @if (is_null($agenda))
                                    N/D
                                @else
                                    {{ $agenda->fecha_agenda }}
                                    |
                                    {{ $agenda->horario }}
                                @endif
                            </td>
                            <td>{{ $donante->sexo }}</td>
                            <td><span class="estado">{{ $donante->estado }}</span></td>
                        </tr>
                    </tbody>
                </table>

                @if (session('mensaje'))
                    <div class="alert alert-success">
                        {{ session('mensaje') }}
                    </div>
                @endif

            </div>
            <div class="d-flex justify-content-center flex-wrap gap-3 mt-1">
                @if ($agenda && $agenda->asistio == null)
                    @php
                        $fechaAgenda = \Carbon\Carbon::parse($agenda->fecha_agenda)->toDateString();
                        $hoy = \Carbon\Carbon::now()->toDateString();
                    @endphp

                    @if ($hoy >= $fechaAgenda && strtolower($donante->estado) === strtolower('Para Actualizar'))
                        <div class="text-center">
                            <a href="{{ route('diferimento.create', ['donante_id' => $donante->id]) }}"
                                class="btn btn-danger d-inline-block">Donante Diferido</a>
                            <a href="{{ route('donacion.create', ['donante_id' => $donante->id]) }}"
                                class="btn btn-primary d-inline-block">Agregar donación</a>
                        </div>

                        <form action="{{ route('donante.no_asistio', ['id' => $donante->id]) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">No asistió</button>
                        </form>
                    @endif
                @endif

                @if (strtolower($donante->estado) === strtolower('Notificado') || strtolower($donante->estado) === strtolower('Disponible'))
                    <a href="{{ route('agenda.create', ['donante_id' => $donante->id]) }}" class="btn btn-primary">Agendar
                        donante</a>
                @endif
                 @if (strtolower($donante->estado) === strtolower('Disponible'))
                    <!-- Botón de Enviar Recordatorio por WhatsApp con icono -->
                    <form action="{{ route('donante.notificar', ['id' => $donante->id]) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        <button type="submit"
                            onclick="window.open('https://wa.me/598{{ $donante->telefono }}?text=Hola%20{{ urlencode($donante->nombre) }}%20{{ urlencode($donante->apellido) }}%2C%20te%20informamos%20que%20ya%20estás%20apto%20para%20donar%20sangre.%20¡Esperamos%20tu%20contribución%21', '_blank')"
                            class="btn btn-success">
                            <i class="fab fa-whatsapp"></i> Enviar Recordatorio
                        </button>
                    </form>
                @endif
            </div>
            <div class="row mt-4">

                <!-- Historial de donaciones -->
                <div class="col-md-6 mb-4 border rounded p-3">
                    <h3>Historial de donaciones</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($donaciones->isEmpty())
                                    <tr>
                                        <td colspan="2">No hay donaciones registradas.</td>
                                    </tr>
                                @else
                                    @foreach ($donaciones as $donacion)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#modalDonacion"
                                                    data-fecha="{{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}"
                                                    data-serologia="{{ $donacion->serologia }}"
                                                    data-anticuerpos_irregulares="{{ $donacion->anticuerpos_irregulares }}"
                                                    data-clase_donacion="{{ $donacion->clase_donacion }}">
                                                    Más detalle
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Historial de diferimientos -->
                <div class="col-md-6 mb-4 border rounded p-3">
                    <h3>Historial de diferimiento</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($diferimientos->isEmpty())
                                    <tr>
                                        <td colspan="2">No hay diferimientos registrados.</td>
                                    </tr>
                                @else
                                    @foreach ($diferimientos as $diferimiento)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($diferimiento->fecha_diferimiento)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#modalDiferimiento"
                                                    data-fecha="{{ \Carbon\Carbon::parse($diferimiento->fecha_diferimiento)->format('d/m/Y') }}"
                                                    data-tipo="{{ $diferimiento->tipo }}"
                                                    data-tiempo_en_meses="{{ $diferimiento->tiempo_en_meses }}"
                                                    data-motivo="{{ $diferimiento->motivo }}">
                                                    Más detalle
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div>
            <a href="{{ route(name: 'donante.index') }}" class="btn btn-lg btn-info ">Volver</a>
        </div>
    </div>
@endsection


<!-- Modal de Diferimiento -->
<div class="modal fade" id="modalDiferimiento" tabindex="-1" aria-labelledby="modalDiferimientoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDiferimientoLabel">Detalle del diferimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                <p><strong>Motivo:</strong> <span id="modalMotivo"></span></p>
                <p><strong>Tipo:</strong> <span id="modalTipo"></span></p>
                <p><strong>Tiempo en meses:</strong> <span id="modalTiempo"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Donación -->
<div class="modal fade" id="modalDonacion" tabindex="-1" aria-labelledby="modalDonacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDonacionLabel">Detalle de la donación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p><strong>Fecha:</strong> <span id="donacionFecha"></span></p>
                <p><strong>Serología:</strong> <span id="donacionSerologia"></span></p>
                <p><strong>Anticuerpos irregulares:</strong> <span id="donacionAnticuerpos"></span></p>
                <p><strong>Clase de donación:</strong> <span id="donacionClase"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    const modal = document.getElementById('modalDiferimiento');
    modal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const fecha = button.getAttribute('data-fecha');
        const motivo = button.getAttribute('data-motivo');
        const tipo = button.getAttribute('data-tipo');
        const tiempo_en_meses = button.getAttribute('data-tiempo_en_meses');

        modal.querySelector('#modalFecha').textContent = fecha;
        modal.querySelector('#modalMotivo').textContent = motivo;
        modal.querySelector('#modalTipo').textContent = tipo;
        modal.querySelector('#modalTiempo').textContent = tiempo_en_meses;
    });
</script>

<script>
    const modalDonacion = document.getElementById('modalDonacion');
    modalDonacion.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const fecha = button.getAttribute('data-fecha');
        const serologia = button.getAttribute('data-serologia');
        const anticuerpos = button.getAttribute('data-anticuerpos_irregulares');
        const clase = button.getAttribute('data-clase_donacion');

        modalDonacion.querySelector('#donacionFecha').textContent = fecha;
        modalDonacion.querySelector('#donacionSerologia').textContent = serologia;
        modalDonacion.querySelector('#donacionAnticuerpos').textContent = anticuerpos;
        modalDonacion.querySelector('#donacionClase').textContent = clase;
    });
</script>
