<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Donacion;
use App\Models\Donante;
use Illuminate\Http\Request;
use App\Enums\TipoABO;
use App\Enums\TipoRH;
use App\Enums\EstadoDonante;
use App\Enums\Sexo;

class DonanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['donantes'] = Donante::paginate(10);


        return view('donante.index', $datos);
    }

    public function home()
    {
        $datos['donantes'] = Donante::paginate(10);
        return view('administrador.homeDonante', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donante.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosDonante = $request->except('_token');

        Donante::insert($datosDonante);

        return redirect('donante')->with('mensaje', 'Se agrego el donante correctamente');
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
        $donante = Donante::findOrFail($id);
        return view('donante.edit', compact('donante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $datosDonante = request()->except(['_token', '_method']);
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
}
