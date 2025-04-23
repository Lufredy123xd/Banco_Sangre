<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; // Asegúrate de tener este modelo creado

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        // Si usas vistas, retorna una vista aquí
        return view('usuarios.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
        ]);

        $usuario = Usuario::create([
            'nombre' => $validatedData['nombre'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json(['message' => 'Usuario creado con éxito', 'usuario' => $usuario], 201);
    }

    /**
     * Muestra un usuario específico.
     */
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        // Si usas vistas, retorna una vista aquí
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8',
        ]);

        $usuario->update([
            'nombre' => $validatedData['nombre'] ?? $usuario->nombre,
            'email' => $validatedData['email'] ?? $usuario->email,
            'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $usuario->password,
        ]);

        return response()->json(['message' => 'Usuario actualizado con éxito', 'usuario' => $usuario]);
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }
}