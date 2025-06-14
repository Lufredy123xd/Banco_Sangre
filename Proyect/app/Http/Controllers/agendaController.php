<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDonante;
use App\Models\Agenda;
use App\Models\Donante;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaController extends Controller
{
    public function exportarPDF(Request $request)
    {
        $query = Agenda::with('donante');

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if ($fechaInicio) {
            $query->where('fecha_agenda', '>=', $fechaInicio);
        }

        if ($fechaFin) {
            $query->where('fecha_agenda', '<=', $fechaFin);
        }

        $agendas = $query->orderBy('fecha_agenda', 'desc')->get();

        // Generar mensaje del rango
        $rangoFechas = null;
        if ($fechaInicio && $fechaFin) {
            $rangoFechas = 'Agendas entre el ' . date('d/m/Y', strtotime($fechaInicio)) . ' y el ' . date('d/m/Y', strtotime($fechaFin));
        } elseif ($fechaInicio) {
            $rangoFechas = 'Agendas desde el ' . date('d/m/Y', strtotime($fechaInicio));
        } elseif ($fechaFin) {
            $rangoFechas = 'Agendas hasta el ' . date('d/m/Y', strtotime($fechaFin));
        }

        $pdf = Pdf::loadView('agenda.pdf', compact('agendas', 'rangoFechas'));
        return $pdf->download('agendas.pdf');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Cargamos las agendas junto con los datos del donante relacionado
        $datos['agendas'] = Agenda::with('donante')->orderBy('fecha_agenda', 'desc')->paginate(10);

        // Retornamos la vista con los datos de las agendas y estados
        return view('agenda.index', $datos);
    }




    public function buscar(Request $request)
    {
        \Log::info('Llamada a buscar()', [
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'page' => $request->page,
        ]);

        $query = Agenda::with('donante');

        if ($request->filled('fecha_inicio')) {
            \Log::info('Filtrando desde fecha_inicio', ['fecha_agenda >=' => $request->fecha_inicio]);
            $query->where('fecha_agenda', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            \Log::info('Filtrando hasta fecha_fin', ['fecha_agenda <=' => $request->fecha_fin]);
            $query->where('fecha_agenda', '<=', $request->fecha_fin);
        }

        // Ordenar por fecha_agenda descendente (más recientes primero)
        $query->orderBy('fecha_agenda', 'desc');

        $agendas = $query->paginate(10);

        \Log::info('Cantidad de agendas encontradas', ['count' => $agendas->count()]);

        $tabla = view('agenda.partials.tabla', compact('agendas'))->render();
        $paginacion = $agendas->links('pagination::bootstrap-5')->render();

        return response()->json([
            'tabla' => $tabla,
            'paginacion' => $paginacion,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        // Obtenemos el id del donante
        $donanteId = $request->input('donante_id');

        // Buscamos el donante por su ID
        $donante = Donante::findOrFail($donanteId);
        $donante->estado = EstadoDonante::Agendado->value; // Aseguramos que el estado sea "Disponible"
        $donante->save();

        // Pasamos el donante a la vista
        return view('agenda.create', compact('donante'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosAgenda = $request->except('_token');
        $donanteId = $request->input('id_donante');
        $donante = Donante::findOrFail($donanteId);
        $donante->estado = EstadoDonante::Agendado->value;
        $donante->save();
        Agenda::insert($datosAgenda);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'mensaje' => 'Se agendó correctamente']);
        }

        return redirect()->route('gestionarDonante', ['id' => $donanteId])
            ->with('mensaje', 'Se agendó correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        $donante = Donante::findOrFail($agenda->id_donante);

        return view('agenda.edit', compact('agenda', 'donante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosAgenda = request()->except(['_token', '_method']);

        Agenda::where('id', '=', $id)->update($datosAgenda);
        $agenda = Agenda::findOrFail($id);
        return redirect()->route('agenda.edit', $id)->with('mensaje', 'Se actualizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $donante = Donante::findOrFail(Agenda::findOrFail($id)->id_donante);
        if ($donante->estado !== EstadoDonante::Agendado->value) {
            return redirect('agenda')->with('error', 'El donante no está agendado.');
        }

        if ($donante) {
            $donante->estado = EstadoDonante::Disponible->value; // Cambiamos el estado del donante a "Agendado"
            $donante->save();
            Agenda::destroy($id);
        } else {
            return redirect('agenda')->with('error', 'Donante no encontrado.');
        }
        return redirect('agenda')->with('mensaje', 'Se elimino correctamente');
    }
}
