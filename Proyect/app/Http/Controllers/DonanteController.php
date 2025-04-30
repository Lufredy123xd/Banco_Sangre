<?php

namespace App\Http\Controllers;

use App\Models\Donante;
use App\Models\Donacion;
use Illuminate\Http\Request;

class DonanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['donantes'] = Donante::paginate(10);

        $donaciones = Donacion::all();


        return view('donante.index', $datos, compact('donaciones'));
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
}
