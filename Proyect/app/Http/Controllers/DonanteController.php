<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDonante;
use App\Models\Agenda;
use App\Models\Diferimento;
use App\Models\Donacion;
use App\Models\Donante;
use App\Models\Usuario;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Laravel\Pail\ValueObjects\Origin\Console;


class DonanteController extends Controller
{

    public function exportPdf()
    {
        // Obtener todos los donantes
        $donantes = Donante::all();

        // Obtener todas las donaciones, sin necesidad de "eager loading" en este caso
        $donaciones = Donacion::all();

        // Generar el PDF con la vista 'donante.pdf' y pasar los donantes y las donaciones
        $pdf = Pdf::loadView('donante.pdf', compact('donantes', 'donaciones'));

        // Descargar el archivo PDF
        return $pdf->download('donantes.pdf');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        $datos['donantes'] = Donante::paginate(10);

        $donaciones = Donacion::all();


        return view('donante.index', $datos, compact('donaciones'));
    }

    public function home()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        $datos['donantes'] = Donante::paginate(10);
        return view('administrador.homeDonante', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        return view('donante.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'cedula' => 'required|digits:8|unique:donantes,cedula', // Cédula única y exactamente 8 dígitos
            'nombre' => 'required|string|max:50', // Nombre obligatorio, texto y máximo 50 caracteres
            'apellido' => 'required|string|max:50', // Apellido obligatorio, texto y máximo 50 caracteres
            'telefono' => 'required|digits_between:7,15', // Teléfono obligatorio, entre 7 y 15 dígitos
            'fecha_nacimiento' => 'required|date|before_or_equal:today', // Fecha de nacimiento obligatoria y no puede ser futura
            'observaciones' => 'nullable|string|max:255', // Observaciones opcionales, máximo 255 caracteres
        ]);

        // Guardar los datos del donante
        $datosDonante = $request->except('_token');
        Donante::create($datosDonante);

        // Redirigir con mensaje de éxito
        return redirect('donante')->with('mensaje', 'Se agregó el donante correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donante $donante)
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

        $donante = Donante::findOrFail($id);
        return view('donante.edit', compact('donante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $datosDonante = request()->except(['_token', '_method']);

        // Asignar el usuario actual como modificador
        $datosDonante['modificado_por'] = session('usuario_id');

        Donante::where('id', '=', $id)->update($datosDonante);
        $donante = Donante::findOrFail($id);
        return redirect()->route('donante.edit', $id)->with('mensaje', 'Donante actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Donante::destroy($id);

        return redirect('donante')->with('mensaje', 'Donante eliminado correctamente');
    }


    public function noAsistio($id)
    {
        $donante = Donante::findOrFail($id);

        $agenda = Agenda::where('id_donante', $id)
            ->whereNull('asistio')  // Esto agrega la condición donde 'asistio' es null
            ->orderByDesc('fecha_agenda')
            ->first();

        if ($agenda) {
            $agenda->asistio = false;
            $agenda->save();
        }


        $donante->estado = EstadoDonante::Disponible->value;
        $donante->save();

        return redirect()->route('gestionarDonante', ['id' => $id])
            ->with('mensaje', 'Se actualizo la asistencia del donante');
    }

    public function getDetails($id)
    {
        // Obtiene el donante con los conteos de donaciones y diferimientos
        $donante = Donante::findOrFail($id);

        $donante->donaciones_count = Donacion::where('id_donante', $id)->count();
        $donante->diferimientos_count = Diferimento::where('id_donante', $id)->count();

        $usuario = null;

        if ($donante->modificado_por === null) {
            $donante->modificado_por = 'N/A';
        } else {
            $usuario = Usuario::findOrFail($donante->modificado_por);
        }

        // Devuelve los datos del donante como JSON
        return response()->json([
            'id' => $donante->id,
            'nombre' => $donante->nombre,
            'apellido' => $donante->apellido,
            'cedula' => $donante->cedula,
            'sexo' => $donante->sexo,
            'telefono' => $donante->telefono,
            'fecha_nacimiento' => \Carbon\Carbon::parse($donante->fecha_nacimiento)->format('d/m/Y'),
            'ABO' => $donante->ABO,
            'RH' => $donante->RH,
            'estado' => $donante->estado,
            'observaciones' => $donante->observaciones,
            'donaciones_count' => $donante->donaciones_count, // Conteo de donaciones
            'diferimientos_count' => $donante->diferimientos_count, // Conteo de diferimientos
            'modificado_por' => $usuario ? $usuario->nombre . ' ' . $usuario->apellido : 'N/A', // Nombre del usuario que modificó

        ]);
    }

    public function notificar($id)
    {
        $donante = Donante::findOrFail($id);
        $donante->estado = 'Notificado';
        $donante->modificado_por = session('usuario_id');
        $donante->ultima_modificacion = now();
        $donante->save();

        return redirect()->route('gestionarDonante', ['id' => $id])
            ->with('mensaje', 'Donante notificado correctamente');
    }
}
