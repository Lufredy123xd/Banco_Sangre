@extends('layouts.app')

@section('content')
    <div class="content__main">
        <div class="content__main">

            <div class="content__main__center">
                <table>
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
                            <td>{{ $donante->ultima_donacion ?? 'N/A' }}</td>
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

                <div>


                    @if ($agenda && $agenda->asistio == null)
                        @php
                            $fechaAgenda = \Carbon\Carbon::parse($agenda->fecha_agenda)->toDateString();
                            $hoy = \Carbon\Carbon::now()->toDateString();

                        @endphp

                        @if ($hoy >= $fechaAgenda && strtolower($donante->estado) === strtolower('Para Actualizar'))
                            <a href="{{ route('diferimento.create', ['donante_id' => $donante->id]) }}"
                                class="btn btn-primary">Diferir donante</a>

                            <a href="{{ route('donacion.create', ['donante_id' => $donante->id]) }}"
                                class="btn btn-primary">Agregar donación</a>

                            <form action="{{ route('donante.no_asistio', ['id' => $donante->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">No asistió</button>
                            </form>
                        @endif
                    @endif

                    @if (strtolower($donante->estado) === strtolower('Disponible'))
                        <a href="{{ route('agenda.create', ['donante_id' => $donante->id]) }}"
                            class="btn btn-primary">Agendar donante</a>
                    @endif

                </div>

                <div>
                    <h3>Historial de diferimiento</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Opcion</th>
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
                                        <td>{{ $diferimiento->fecha_diferimiento }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#modalDiferimiento"
                                                data-fecha="{{ $diferimiento->fecha_diferimiento }}"
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

                    <h3>Historial de donaciones</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($donaciones->isEmpty())
                                <tr>
                                    <td colspan="2">No hay donaciones registrados.</td>
                                </tr>
                            @else
                                @foreach ($donaciones as $donacion)
                                    <tr>
                                        <td>{{ $donacion->fecha }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#modalDonacion" data-fecha="{{ $donacion->fecha }}"
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
            @if (session('mensaje'))
                <div class="alert alert-success">
                    {{ session('mensaje') }}
                </div>
            @endif
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

