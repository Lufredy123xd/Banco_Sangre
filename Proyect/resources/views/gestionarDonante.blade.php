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

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

                <div class="d-flex gap-2">


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
                @if (session('mensaje'))
                    <div class="alert alert-success">
                        {{ session('mensaje') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
