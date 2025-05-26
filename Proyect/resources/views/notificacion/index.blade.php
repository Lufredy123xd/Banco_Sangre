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
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $notificacion->titulo }}</strong><br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($notificacion->fecha)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($notificacion->hora)->format('H:i') }}
                                        </small>
                                        <p class="mb-1">{{ $notificacion->descripcion }}</p>
                                        <span class="badge bg-secondary">{{ $notificacion->estado }}</span>
                                    </div>
                                    <form action="{{ route('notificacion.destroy', $notificacion->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
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
            <a href="{{ route('donacion.index') }}" class="btn btn-primary">Volver a Donaciones</a>
        </div>
    </div>

@endsection
