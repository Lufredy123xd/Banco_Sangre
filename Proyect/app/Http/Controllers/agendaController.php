<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDonante;
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
        // Captura todos los datos menos el token
        $datosAgenda = $request->except('_token');

        // Captura el donante_id desde la URL (query string)
        $donanteId = $request->input('id_donante');

        // Buscamos el donante por su ID
        $donante = Donante::findOrFail($donanteId);
        $donante->estado = EstadoDonante::Agendado->value; // Cambiamos el estado del donante a "Agendado"
        $donante->save();

        // Inserta la agenda con los datos
        Agenda::insert($datosAgenda);

        // Redirige a la página de gestionarDonante, pasando el id del donante
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
