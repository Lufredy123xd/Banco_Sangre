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

        if (session('tipo_usuario') !== 'Administrador') {
            abort(403, 'Acceso no autorizado.');
        }

        $usuarios = Usuario::paginate(5); // o ->all() si querés traer todos
        return view('usuario.index', compact('usuarios'));
    }


    public function create()
    {
        if (session('tipo_usuario') !== 'Administrador') {
            abort(403, 'Acceso no autorizado.');
        }
        return view('usuario.registrar');
    }


    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        // Eliminar todos los datos de la sesión
        session()->flush();
    
        // Redirigir a la página de inicio de sesión
        return redirect('/')->with('mensaje', 'Sesión cerrada correctamente.');
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
            // Validar estado activo
            if (strtolower($usuario->estado) !== 'activo') {
                return back()->withErrors(['login_error' => 'El usuario no está activo.']);
            }

            // Guardar información del usuario en la sesión
            session([
                'usuario_id' => $usuario->id,
                'user_name' => $usuario->user_name,
                'tipo_usuario' => $usuario->tipo_usuario,
            ]);

            // Redirección condicional
            if ($usuario->tipo_usuario === 'Administrador') {
                return redirect()->route('usuario.index')->with('mensaje', 'Bienvenido administrador.');
            } elseif (in_array($usuario->tipo_usuario, ['Docente', 'Estudiante', 'Funcionario'])) {
                return redirect()->route('donante.index')->with('mensaje', 'Bienvenido al sistema.');
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


        dump($data); // Para depurar y ver los datos que se están guardando

        Usuario::create($data);

        return redirect()->route('usuario.index')->with('mensaje', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        if (session('tipo_usuario') !== 'Administrador') {
            abort(403, 'Acceso no autorizado.');
        }
        $usuario = Usuario::findOrFail($id);
        return view('usuario.editar', compact('usuario'));
    }

    /**
     * Actualiza la información de un usuario existente.
     */
    // El método update recibe el ID del usuario a actualizar y los datos del formulario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->except('_token'); // Elimina el _token del array de datos
        
        if ($data['password'] == null) {
            $data['password'] = $usuario->password; // Mantiene la contraseña actual si no se proporciona una nueva
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        
    

        $usuario->update($data);

        return redirect()->route('usuario.index')->with('mensaje', 'Usuario modificado correctamente.');
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
