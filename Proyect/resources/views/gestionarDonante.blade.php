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
                            <th>Fecha agendada</th>
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
                                @if ($agenda->isEmpty())
                                    N/D
                                @else
                                    {{ $agenda->first()->fecha_agenda }}
                                @endif
                            </td>
                            <td>{{ $donante->sexo }}</td>
                            <td><span class="estado">{{ $donante->estado }}</span></td>
                        </tr>
                    </tbody>
                </table>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

                <div class="d-flex gap-2">

                    @if (!$agenda->isEmpty() && $agenda->first()->asistio == null)

                        @php
                            $fechaAgenda = \Carbon\Carbon::parse($agenda->first()->fecha_agenda)->toDateString();
                            $hoy = \Carbon\Carbon::now()->toDateString();
                        @endphp

                        
                        @if ($hoy > $fechaAgenda && $donante->estado === 'Para actualizar')
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

                    @if ($agenda->isEmpty())
                        @if ($donante->estado === 'Disponible')
                            <a href="{{ route('agenda.create', ['donante_id' => $donante->id]) }}"
                                class="btn btn-primary">Agendar donante</a>
                        @endif
                    @endif
             




                </div>
            </div>
        </div>
    </div>
@endsection
