<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\VarDumper;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::paginate(5); // o ->all() si querés traer todos
        return view('administrador.index', compact('usuarios'));
    }

    public function home()
    {
        $usuarios = Usuario::all(); // Obtiene todos los usuarios de la base de datos
        return view('administrador.home', compact('usuarios')); // Pasa los usuarios a la vista
    }

    public function verMas($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('administrador.verMas', compact('usuario')); // Pasa los usuarios a la vista
    }

    public function create()
    {
        return view('administrador.registrar');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token'); // Elimina el _token del array de datos

        $data['password'] = Hash::make($data['password']);

        Usuario::create($data);

        return redirect()->route('administrador.index')->with('mensaje', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('administrador.editar', compact('usuario'));
    }

    /**
     * Actualiza la información de un usuario existente.
     */
    // El método update recibe el ID del usuario a actualizar y los datos del formulario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->except('_token'); // Elimina el _token del array de datos
        $data['password'] = Hash::make($data['password']);


        $usuario->update($data);

        return redirect()->route('administrador.index')->with('mensaje', 'Usuario modificado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('administrador.index')->with('mensaje', 'Usuario eliminado correctamente.');
    }
}
