<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDonante;
use App\Models\Agenda;
use App\Models\Diferimento;
use App\Models\Donante;
use Illuminate\Http\Request;

class DiferimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('tipo_usuario') !== 'Administrador' &&  session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }
        $datos['diferimentos'] = Diferimento::paginate(10);
        return view('diferimento.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (session('tipo_usuario') !== 'Administrador' &&  session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }
        // Obtenemos el id del donante
        $donanteId = $request->input('donante_id');

        // Buscamos el donante por su ID
        $donante = Donante::findOrFail($donanteId);

        // Pasamos el donante a la vista
        return view('diferimento.create', compact('donante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosDiferimento = request()->except('_token');
        Diferimento::insert($datosDiferimento);

        // Captura el donante_id desde la URL (query string)
        $donanteId = $request->input('id_donante');

        $agenda = Agenda::where('id_donante', $donanteId)
            ->whereNull('asistio')  // Esto agrega la condición donde 'asistio' es null
            ->orderByDesc('fecha_agenda')
            ->first();
        $agenda->asistio = true; // Cambiamos el estado del donante a "Agendado"
        $agenda->save();

        // Buscamos el donante por su ID
        $donante = Donante::findOrFail($donanteId);
        $donante->estado = EstadoDonante::No_Disponible->value; // Cambiamos el estado del donante a "Agendado"
        $donante->save();
        
        return redirect()->route('gestionarDonante', ['id' => $donanteId])
            ->with('mensaje', 'Se diferio correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diferimento $diferimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (session('tipo_usuario') !== 'Administrador' &&  session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }
        $diferimento = Diferimento::findOrFail($id);
        $donante = Donante::findOrFail($diferimento->donante_id);
        return view('diferimento.edit', compact('diferimento', 'donante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosDiferimento = request()->except(['_token', '_method']);
        Diferimento::where('id', '=', $id)->update($datosDiferimento);
        
        return redirect('diferimento.edit')->with('mensaje', 'Se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Diferimento::destroy($id);
        
        return redirect('diferimento')->with('mensaje', 'Se elimino correctamente');
    }
}
