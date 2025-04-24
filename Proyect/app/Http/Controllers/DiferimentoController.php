<?php

namespace App\Http\Controllers;

use App\Models\Diferimento;
use Illuminate\Http\Request;

class DiferimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos['diferimentos'] = Diferimento::paginate(5);
        return view('diferimento.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(view: 'diferimento.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosDiferimento = request()->except('_token');
        Diferimento::insert($datosDiferimento);
        
        return redirect('diferimento/create')->with('mensaje', 'Se diferio correctamente');
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
        $diferimento = Diferimento::findOrFail($id);
        return view('diferimento.edit', compact('diferimento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosDiferimento = request()->except(['_token', '_method']);
        Diferimento::where('id', '=', $id)->update($datosDiferimento);
        
        return redirect('diferimento')->with('mensaje', 'Se actualizo correctamente');
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
