<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Donante;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['agendas'] = Agenda::paginate(10);
        return view('agenda.index', $datos);
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

        // Pasamos el donante a la vista
        return view('agenda.create', compact('donante'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosAgenda = request()->except('_token');

        Agenda::insert($datosAgenda);

        return redirect('donante')->with('mensaje', 'Se agendo correctamente');

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
        $donante = Donante::findOrFail($agenda->donante_id);
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
        Agenda::destroy($id);
        return redirect('agenda')->with('mensaje', 'Se elimino correctamente');
    }
}
