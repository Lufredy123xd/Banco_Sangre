<?php

namespace App\Http\Controllers;

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
        $datos['donantes'] = Donante::paginate(5);
        return view('donante.index', $datos);
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
        $datosDonante = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|integer|unique:donantes,cedula',
            'sexo' => 'required|in:' . implode(',', array_column(Sexo::cases(), 'value')), // Validar enum
            'telefono' => 'required|string|max:15',
            'fecha_nacimiento' => 'required|date',
            'ABO' => 'required|in:' . implode(',', array_column(TipoABO::cases(), 'value')), // Validar enum
            'RH' => 'required|in:' . implode(',', array_column(TipoRH::cases(), 'value')), // Validar enum
            'estado' => 'required|in:' . implode(',', array_column(EstadoDonante::cases(), 'value')), // Validar enum
            'observaciones' => 'nullable|string',
        ]);

        Donante::create($datosDonante);

        return redirect('donante')->with('mensaje', 'Donante registrado correctamente');
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
    public function update(Request $request, $id)
    {
        $datosDonante = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|integer|unique:donantes,cedula,' . $id,
            'sexo' => 'required|in:' . implode(',', array_column(Sexo::cases(), 'value')), // Validar enum
            'telefono' => 'required|string|max:15',
            'fecha_nacimiento' => 'required|date',
            'ABO' => 'required|in:' . implode(',', array_column(TipoABO::cases(), 'value')), // Validar enum
            'RH' => 'required|in:' . implode(',', array_column(TipoRH::cases(), 'value')), // Validar enum
            'estado' => 'required|in:' . implode(',', array_column(EstadoDonante::cases(), 'value')), // Validar enum
            'observaciones' => 'nullable|string',
        ]);

        Donante::where('id', '=', $id)->update($datosDonante);

        return redirect('donante')->with('mensaje', 'Donante actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Donante::destroy($id);
        
        return redirect('donante')->with('mensaje', 'Donante eliminado correctamente');
    }
}
