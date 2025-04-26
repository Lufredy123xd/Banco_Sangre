<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use App\Models\Donante;
use App\Enums\TipoSerologia;
use App\Enums\TipoAnticuerposIrregulares;
use App\Enums\TipoDonacion;
use Illuminate\Http\Request;

class DonacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['donaciones'] = Donacion::with('donante')->paginate(5);
        return view('donacion.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $donantes = Donante::all(); // Obtener todos los donantes
        return view('donacion.create', compact('donantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosDonacion = $request->validate([
            'id_donante' => 'required|exists:donantes,id',
            'fecha' => 'required|date',
            'clase_donacion' => 'required|in:' . implode(',', array_column(TipoDonacion::cases(), 'value')), // Validar enum
            'serologia' => 'required|in:' . implode(',', array_column(TipoSerologia::cases(), 'value')), // Validar enum
            'anticuerpos_irregulares' => 'required|in:' . implode(',', array_column(TipoAnticuerposIrregulares::cases(), 'value')), // Validar enum
        ]);

        Donacion::create($datosDonacion);

        return redirect('donacion')->with('mensaje', 'Donación registrada correctamente');
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
}
