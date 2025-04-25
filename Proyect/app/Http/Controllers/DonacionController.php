<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use Illuminate\Http\Request;

class DonacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['donaciones'] = Donacion::paginate(5);
        return view('donacion.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosDonacion = request()->except('_token');
        Donacion::insert($datosDonacion);
        
        return redirect('donacion/create')->with('mensaje', 'Donación registrada correctamente');
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
        return view('donacion.edit', compact('donacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosDonacion = request()->except(['_token', '_method']);
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
