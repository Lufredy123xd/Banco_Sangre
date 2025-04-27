<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::paginate(5); // o ->all() si querés traer todos
        return view('usuario.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuario.crearUsuario');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'rol' => 'required|in:Administrador,Docente,Estudiante,Funcionario',
            'password' => 'required|string|min:8',
        ]);

        // Hash the password before saving
        $validatedData['password'] = Hash::make($validatedData['password']);
        Usuario::create($validatedData);

        return redirect()->route('usuario.index')->with('mensaje', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuario.modificarUsuario', compact('usuario'));
    }

    /**
     * Actualiza la información de un usuario existente.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'rol' => 'required|in:Administrador,Docente,Estudiante,Funcionario',
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $usuario->update($validatedData);

        return redirect()->route('usuario.index')->with('mensaje', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuario.index')->with('mensaje', 'Usuario eliminado correctamente.');
    }
}
