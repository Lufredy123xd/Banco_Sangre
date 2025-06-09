<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDonante;
use App\Models\Agenda;
use App\Models\Diferimento;
use App\Models\Donacion;
use App\Models\Donante;
use App\Enums\TipoSerologia;
use App\Enums\TipoAnticuerposIrregulares;
use App\Enums\TipoDonacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DonacionController extends Controller
{


    public function exportPdf()
    {
        // Obtener todas las donaciones, sin necesidad de "eager loading" en este caso
        $donaciones = Donacion::all();
        $donantes = Donante::all();

        // Generar el PDF con la vista 'donante.pdf' y pasar los donantes y las donaciones
        $pdf = Pdf::loadView('donacion.pdf', compact('donaciones', 'donantes'));

        // Descargar el archivo PDF
        return $pdf->download('donaciones.pdf');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        $datos['donaciones'] = Donacion::with('donante')->orderBy('fecha', 'desc')->paginate(10);



        return view('donacion.index', $datos);
    }

    public function buscar(Request $request)
    {
        $query = Donacion::with('donante');

        if ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        $query->orderBy('fecha', 'desc');
        $donaciones = $query->paginate(10);

        $tabla = view('donacion.partials.table', compact('donaciones'))->render();
        $paginacion = $donaciones->links('pagination::bootstrap-5')->render();

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
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }
        $donanteId = $request->query('donante_id'); // Captura el parámetro donante_id
        $donante = Donante::findOrFail($donanteId); // Busca el donante por ID

        return view('donacion.create', compact('donante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosDonacion = $request->validate([
            'id_donante' => 'required|exists:donantes,id',
            'fecha' => 'required|date',
            'clase_donacion' => 'required|in:' . implode(',', array_column(TipoDonacion::cases(), 'value')),
            'serologia' => 'required|in:' . implode(',', array_column(TipoSerologia::cases(), 'value')),
            'anticuerpos_irregulares' => 'required|in:' . implode(',', array_column(TipoAnticuerposIrregulares::cases(), 'value')),
        ]);

        // Crear la donación
        Donacion::create($datosDonacion);

        $donanteId = $request->input('id_donante');

        // Actualizar la agenda más reciente del donante
        $agenda = Agenda::where('id_donante', $donanteId)
            ->whereNull('asistio') // Solo agendas sin registro de asistencia
            ->orderBy('fecha_agenda', 'desc')
            ->first();

        if ($agenda) {
            $agenda->asistio = true; // Marcar como asistió
            $agenda->save();
        }

        // Actualizar el estado del donante
        $donante = Donante::findOrFail($donanteId);
        $donante->estado = EstadoDonante::No_Disponible->value;
        $donante->save();

        return redirect()->route('gestionarDonante', ['id' => $donanteId])
            ->with('mensaje', 'Donación registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donacion $donacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }
        $donacion = Donacion::findOrFail($id);
        $donantes = Donante::all(); // Obtener todos los donantes
        return view('donacion.edit', compact('donacion', 'donantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosDonacion = $request->validate([
            'id_donante' => 'required|exists:donantes,id',
            'fecha' => 'required|date',
            'clase_donacion' => 'required|in:' . implode(',', array_column(TipoDonacion::cases(), 'value')), // Validar enum
            'serologia' => 'required|in:' . implode(',', array_column(TipoSerologia::cases(), 'value')), // Validar enum
            'anticuerpos_irregulares' => 'required|in:' . implode(',', array_column(TipoAnticuerposIrregulares::cases(), 'value')), // Validar enum
        ]);

        Donacion::where('id', '=', $id)->update($datosDonacion);

        return redirect('donacion')->with('mensaje', 'Donación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Donacion::destroy($id);

        return redirect('donacion')->with('mensaje', 'Donación eliminada correctamente');
    }



    public function gestionarDonante($id)
    {
        $donante = Donante::findOrFail($id); // Buscar el donante por ID

        $agenda = Agenda::where('id_donante', $id)
            ->whereNull('asistio')  // Esto agrega la condición donde 'asistio' es null
            ->orderByDesc('fecha_agenda')
            ->first();


        $diferimientos = Diferimento::where('id_donante', $id)
            ->get();

        $donaciones = Donacion::where('id_donante', $id)
            ->get();


        if ($agenda && now()->toDateString() >= $agenda->fecha_agenda && $donante->estado === EstadoDonante::Agendado->value) {
            $donante->estado = EstadoDonante::ParaActializar->value;
            $donante->save();
        }

        return view('gestionarDonante', compact('donante', 'agenda', 'diferimientos', 'donaciones'));
    }


}
