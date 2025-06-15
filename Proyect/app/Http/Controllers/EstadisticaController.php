<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use App\Models\Diferimento;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstadisticaController extends Controller
{
    public function buscar(Request $request)
    {
        // Donaciones: solidarios vs voluntarios
        $solidarios = Donacion::where('clase_donacion', 'Solidaria');
        $voluntarios = Donacion::where('clase_donacion', 'Voluntaria');
        // Agendados
        $donacionesAgendadas = Agenda::where('asistio', true)->whereHas('donante.donaciones');
        $diferimientosAgendados = Agenda::where('asistio', true)->whereHas('donante.diferimientos');
        $noAsistio = Agenda::where('asistio', false);
        // Diferimientos: Temporales vs Permanentes
        $temporales = Diferimento::where('tipo', 'Temporal');
        $permanentes = Diferimento::where('tipo', 'Permanente');

        if ($request->filled('fecha_inicio')) {
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio);

            $solidarios->whereDate('fecha', '>=', $fechaInicio);
            $voluntarios->whereDate('fecha', '>=', $fechaInicio);
            $donacionesAgendadas->whereDate('fecha_agenda', '>=', $fechaInicio);
            $diferimientosAgendados->whereDate('fecha_agenda', '>=', $fechaInicio);
            $noAsistio->whereDate('fecha_agenda', '>=', $fechaInicio);
            $temporales->whereDate('fecha_diferimiento', '>=', $fechaInicio);
            $permanentes->whereDate('fecha_diferimiento', '>=', $fechaInicio);
        }

        if ($request->filled('fecha_fin')) {
            $fechaFin = Carbon::createFromFormat('Y-m-d', $request->fecha_fin);

            $solidarios->whereDate('fecha', '<=', $fechaFin);
            $voluntarios->whereDate('fecha', '<=', $fechaFin);
            $donacionesAgendadas->whereDate('fecha_agenda', '<=', $fechaFin);
            $diferimientosAgendados->whereDate('fecha_agenda', '<=', $fechaFin);
            $noAsistio->whereDate('fecha_agenda', '<=', $fechaFin);
            $temporales->whereDate('fecha_diferimiento', '<=', $fechaFin);
            $permanentes->whereDate('fecha_diferimiento', '<=', $fechaFin);
        }

        $solidarios = $solidarios->count() ?? 10;
        $voluntarios = $voluntarios->count() ?? 10;
        $donacionesAgendadas = $donacionesAgendadas->count() ?? 10;
        $diferimientosAgendados = $diferimientosAgendados->count() ?? 10;
        $noAsistio = $noAsistio->count() ?? 10;
        $temporales = $temporales->count() ?? 10;
        $permanentes = $permanentes->count() ?? 10;

        $tabla = view('estadisticas.partials.table', compact('solidarios', 'voluntarios', 'donacionesAgendadas', 'diferimientosAgendados', 'noAsistio', 'temporales', 'permanentes'))->render();

        return response()->json([
            'tabla' => $tabla,
            'datos' => [
                'solidarios' => $solidarios,
                'voluntarios' => $voluntarios,
                'donacionesAgendadas' => $donacionesAgendadas,
                'diferimientosAgendados' => $diferimientosAgendados,
                'noAsistio' => $noAsistio,
                'temporales' => $temporales,
                'permanentes' => $permanentes
            ]
        ]);
    }

    public function index()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }
        // Donaciones: solidarios vs voluntarios
        $solidarios = Donacion::where('clase_donacion', 'Solidaria')->count();
        $voluntarios = Donacion::where('clase_donacion', 'Voluntaria')->count();

        // Agendados
        $donacionesAgendadas = Agenda::where('asistio', true)->whereHas('donante.donaciones')->count();
        $diferimientosAgendados = Agenda::where('asistio', true)->whereHas('donante.diferimientos')->count();
        $noAsistio = Agenda::where('asistio', false)->count();

        // Diferimientos: Temporales vs Permanentes
        $temporales = Diferimento::where('tipo', 'Temporal')->count();
        $permanentes = Diferimento::where('tipo', 'Permanente')->count();

        
        return view('estadisticas.index', compact(
            'solidarios',
            'voluntarios',
            'donacionesAgendadas',
            'diferimientosAgendados',
            'noAsistio',
            'temporales',
            'permanentes'
        ));
    }
}

