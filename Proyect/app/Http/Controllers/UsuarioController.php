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
        return view('administrador.home', compact('usuarios'));
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
     * Muestra el formulario para crear un nuevo usuario.
     */

     public function authenticate(Request $request)
     {
         $request->validate([
             'user_name' => 'required|string',
             'password' => 'required|string',
         ]);
     
         $usuario = Usuario::where('user_name', $request->user_name)->first();
     
         if ($usuario && Hash::check($request->password, $usuario->password)) {
             // Guardar información del usuario en la sesión
             session([
                 'usuario_id' => $usuario->id,
                 'user_name' => $usuario->user_name,
                 'tipo_usuario' => $usuario->tipo_usuario,
             ]);
     
             // Redirección condicional
             if ($usuario->tipo_usuario === 'Administrador') {
                 return redirect()->route('administrador.home')->with('mensaje', 'Bienvenido administrador.');
             } elseif (in_array($usuario->tipo_usuario, ['Docente', 'Estudiante', 'Funcionario'])) {
                 return redirect()->route('usuario.index')->with('mensaje', 'Bienvenido al sistema.');
             } else {
                 return back()->withErrors(['login_error' => 'Tipo de usuario no autorizado.']);
             }
         }
     
         return back()->withErrors(['login_error' => 'Usuario o contraseña incorrectos.']);
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
