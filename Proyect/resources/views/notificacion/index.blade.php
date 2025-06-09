@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-bell me-2"></i>Notificaciones
                <span class="badge bg-primary">{{ $notificaciones->total() }}</span>
            </h1>
            <a href="{{ route('donante.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Volver a donantes
            </a>
        </div>

        <!-- Tarjeta de notificaciones -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Listado de Notificaciones
                </h5>
            </div>
            
            <div class="card-body p-0">
                @if($notificaciones->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No hay notificaciones</h4>
                        <p class="text-muted">Cuando tengas nuevas notificaciones, aparecerán aquí</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($notificaciones as $notificacion)
                            <div class="list-group-item {{ $notificacion->estado == 'Visto' ? 'bg-light' : 'bg-white' }} border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1 me-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 class="mb-0 {{ $notificacion->estado == 'Visto' ? 'text-muted' : 'text-dark' }}">
                                                <i class="fas {{ $notificacion->estado == 'Visto' ? 'fa-envelope-open' : 'fa-envelope' }} me-2"></i>
                                                {{ $notificacion->titulo }}
                                            </h5>
                                            <span class="badge {{ $notificacion->estado == 'Visto' ? 'bg-secondary' : 'bg-primary' }}">
                                                {{ $notificacion->estado }}
                                            </span>
                                        </div>
                                        
                                        <p class="mb-2 {{ $notificacion->estado == 'Visto' ? 'text-muted' : 'text-dark' }}">
                                            {{ $notificacion->descripcion }}
                                        </p>
                                        
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($notificacion->fecha)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($notificacion->hora)->format('h:i A') }}
                                        </small>
                                    </div>
                                    
                                    @if($notificacion->estado === 'Pendiente')
                                        <form action="{{ route('notificacion.visto', $notificacion->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Marcar como visto">
                                                <i class="fas fa-check me-1"></i> Marcar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Paginación -->
                    <div class="card-footer bg-light">
                        {{ $notificaciones->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .list-group-item {
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa !important;
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }
    </style>
@endsection