@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Notificaciones</h1>
        <div class="row">
            <div class="col-md-12">
                @if($notificaciones->isEmpty())
                    <p>No hay notificaciones.</p>
                @else
                    <ul class="list-group">
                        @foreach($notificaciones as $notificacion)
                            <li class="list-group-item {{ $notificacion->estado == 'Visto' ? 'bg-light text-muted' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $notificacion->titulo }}</strong><br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($notificacion->fecha)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($notificacion->hora)->format('H:i') }}
                                        </small>
                                        <p class="mb-1">{{ $notificacion->descripcion }}</p>
                                        <span class="badge {{ $notificacion->estado == 'Visto' ? 'bg-secondary' : 'bg-primary' }}">
                                            {{ $notificacion->estado }}
                                        </span>
                                    </div>
                                    @if($notificacion->estado === 'Pendiente')
                                        <form action="{{ route('notificacion.visto', $notificacion->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success btn-sm">Marcar como visto</button>
                                        </form>
                                    @else
                                        <span class="text-success">✓ Vista</span>
                                    @endif
                                </div>
                            </li>

                        @endforeach
                    </ul>
                    <div class="mt-3">
                        {{ $notificaciones->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('donante.index') }}" class="btn btn-primary">Volver a donantes</a>
        </div>
    </div>

@endsection