<?php

namespace App\Http\Controllers;

use App\Enums\EstadoDonante;
use App\Models\Agenda;
use App\Models\Diferimento;
use App\Models\Donacion;
use App\Models\Donante;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;


class DonanteController extends Controller
{

    public function exportPdf()
    {
        // Obtener todos los donantes
        $donantes = Donante::all();

        // Obtener todas las donaciones, sin necesidad de "eager loading" en este caso
        $donaciones = Donacion::all();

        // Generar el PDF con la vista 'donante.pdf' y pasar los donantes y las donaciones
        $pdf = Pdf::loadView('donante.pdf', compact('donantes', 'donaciones'));

        // Descargar el archivo PDF
        return $pdf->download('donantes.pdf');
    }

    private function validarCedulaUruguaya($cedula)
    {
        // Eliminar cualquier carácter que no sea dígito
        $cedula = preg_replace('/\D/', '', $cedula);

        // Verificar que la cédula tenga entre 7 y 8 dígitos
        $length = strlen($cedula);
        if ($length < 7 || $length > 8) {
            return false;
        }

        // Completar con ceros a la izquierda si tiene menos de 8 dígitos
        $cedula = str_pad($cedula, 8, '0', STR_PAD_LEFT);

        // Opcional: no permitir cédulas con todos los dígitos iguales
        if (preg_match('/^(\d)\1{7}$/', $cedula)) {
            return false;
        }

        // Separar los primeros 7 dígitos y el dígito verificador
        $numeros = substr($cedula, 0, 7);
        $verificador = intval($cedula[7]);

        // Factores para el cálculo
        $factores = [2, 9, 8, 7, 6, 3, 4];

        // Calcular la suma ponderada
        $suma = 0;
        for ($i = 0; $i < 7; $i++) {
            $suma += intval($numeros[$i]) * $factores[$i];
        }

        // Calcular el dígito verificador esperado
        $resto = $suma % 10;
        $digitoCalculado = $resto === 0 ? 0 : 10 - $resto;

        // Comparar con el dígito verificador proporcionado
        return $verificador === $digitoCalculado;
    }


    public function importCsv(Request $request)
    {
        Log::info('Inicio de importación de CSV de donantes.');

        try {
            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt',
            ]);

            Log::info('Archivo CSV validado correctamente.');

            $file = $request->file('csv_file');

            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                Log::info('Archivo CSV abierto correctamente.');

                $header = null;
                $rowsImported = 0;
                $lineNumber = 0;

                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $lineNumber++;

                    Log::debug("Procesando línea {$lineNumber}: " . json_encode($row));

                    if (!$header) {
                        // Eliminar BOM si existe en la primera columna
                        $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
                        $header = $row;
                        Log::info('Encabezado CSV detectado:', $header);
                        continue;
                    }

                    if (count($row) != count($header)) {
                        Log::warning("Número de columnas incorrecto en línea {$lineNumber}. Esperado " . count($header) . ", encontrado " . count($row));
                        continue; // saltar fila mal formateada
                    }

                    $data = array_combine($header, $row);

                    // Limpiar cédula: quitar puntos, guiones y espacios
                    $cedula = preg_replace('/[^\d]/', '', $data['cedula'] ?? '');

                    // Formatear fecha_nacimiento a Y-m-d
                    $fecha_nacimiento = null;
                    if (!empty($data['fecha_nacimiento'])) {
                        try {
                            // Intenta varios formatos comunes
                            $fecha_nacimiento = \Carbon\Carbon::createFromFormat('Y-m-d', $data['fecha_nacimiento']);
                        } catch (\Exception $e1) {
                            try {
                                $fecha_nacimiento = \Carbon\Carbon::createFromFormat('d-m-Y', $data['fecha_nacimiento']);
                            } catch (\Exception $e2) {
                                try {
                                    $fecha_nacimiento = \Carbon\Carbon::createFromFormat('d/m/Y', $data['fecha_nacimiento']);
                                } catch (\Exception $e3) {
                                    try {
                                        $fecha_nacimiento = \Carbon\Carbon::createFromFormat('d-m-y', $data['fecha_nacimiento']);
                                    } catch (\Exception $e4) {
                                        Log::error("Formato de fecha inválido en línea {$lineNumber}: " . $data['fecha_nacimiento']);
                                        $fecha_nacimiento = null;
                                    }
                                }
                            }
                        }
                        if ($fecha_nacimiento) {
                            $fecha_nacimiento = $fecha_nacimiento->format('Y-m-d');
                        }
                    }

                    try {
                        Donante::updateOrCreate(
                            ['cedula' => $cedula],
                            [
                                'nombre' => $data['nombre'] ?? null,
                                'apellido' => $data['apellido'] ?? null,
                                'sexo' => $data['sexo'] ?? null,
                                'telefono' => $data['telefono'] ?? null,
                                'fecha_nacimiento' => $fecha_nacimiento,
                                'ABO' => $data['ABO'] ?? null,
                                'RH' => $data['RH'] ?? null,
                                'estado' => 'Disponible', // SIEMPRE disponible
                                'observaciones' => $data['observaciones'] ?? null,
                                'ultima_modificacion' => now(),
                                'modificado_por' => session('usuario_id'),
                            ]
                        );
                        $rowsImported++;
                        Log::info("Donante cédula {$cedula} importado correctamente.");
                    } catch (\Exception $e) {
                        Log::error("Error al importar donante cédula {$cedula} en línea {$lineNumber}: " . $e->getMessage() . ' | Data: ' . json_encode($data));
                        continue;
                    }
                }

                fclose($handle);

                Log::info("Importación finalizada. Total de donantes importados: {$rowsImported}");

                return redirect()->route('donante.index')->with('mensaje', "Se importaron {$rowsImported} donantes correctamente.");
            } else {
                Log::error('No se pudo abrir el archivo CSV.');
                return redirect()->route('donante.index')->with('error', 'No se pudo abrir el archivo CSV.');
            }
        } catch (\Exception $e) {
            Log::error('Error inesperado al importar donantes: ' . $e->getMessage());
            return redirect()->route('donante.index')->with('error', 'Ocurrió un error durante la importación. Verifique el archivo CSV e intente nuevamente.');
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        $datos['donantes'] = Donante::paginate(10);

        $donaciones = Donacion::all();


        return view('donante.index', $datos, compact('donaciones'));
    }


    public function buscar(Request $request)
    {
        // Iniciar la consulta básica
        $query = Donante::with('donaciones');

        // Log para verificar los parámetros recibidos
        Log::info('Parámetros recibidos', $request->all());

        if ($request->filled('search')) {
            $search = $request->search;
            $palabras = explode(' ', $search);

            // Log para ver las palabras de búsqueda
            Log::info('Palabras de búsqueda', $palabras);

            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where(function ($q2) use ($palabra) {
                        $q2->where('nombre', 'like', "%{$palabra}%")
                            ->orWhere('apellido', 'like', "%{$palabra}%")
                            ->orWhere('cedula', 'like', "%{$palabra}%");

                        // Log para ver las condiciones dentro del loop
                        Log::info('Condiciones de búsqueda para palabra: ' . $palabra, [
                            'nombre' => "%{$palabra}%",
                            'apellido' => "%{$palabra}%",
                            'cedula' => "%{$palabra}%",
                        ]);
                    });
                }
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
            Log::info('Filtro por estado', ['estado' => $request->estado]);
        }

        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
            Log::info('Filtro por sexo', ['sexo' => $request->sexo]);
        }

        if ($request->filled('abo')) {
            $query->where('ABO', $request->abo);
            Log::info('Filtro por ABO', ['ABO' => $request->abo]);
        }

        if ($request->filled('rh')) {
            $query->where('RH', $request->rh);
            Log::info('Filtro por RH', ['RH' => $request->rh]);
        }

        if ($request->filled('ordenar_por')) {
            Log::info('Ordenar por', ['campo' => $request->ordenar_por, 'orden' => $request->orden ?? 'asc']);

            if ($request->ordenar_por === 'fecha') {
                $query->leftJoin('donacions', 'donantes.id', '=', 'donacions.id_donante')
                    ->select('donantes.*')
                    ->groupBy('donantes.id')
                    ->orderByRaw('MAX(donacions.fecha) IS NULL ASC') // Primero los que tienen donación
                    ->orderByRaw('MAX(donacions.fecha) ' . ($request->orden ?? 'asc'));

                // Log para verificar el join y el orden
                Log::info('Consulta de ordenar por fecha');
            } else {
                $query->orderBy($request->ordenar_por, $request->orden ?? 'asc');

                // Log para verificar el orden
                Log::info('Consulta de ordenar general', ['campo' => $request->ordenar_por, 'orden' => $request->orden ?? 'asc']);
            }
        }

        // Mostrar la consulta generada
        Log::info('Consulta final generada', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

        // Realizar la paginación
        $donantes = $query->paginate(10)->appends($request->all());

        // Ver las vistas parciales de la tabla y paginación
        $tabla = view('donante.partials.tabla', compact('donantes'))->render();
        $paginacion = view('donante.partials.paginacion', compact('donantes'))->render();

        // Log para verificar los resultados finales
        Log::info('Resultados de la consulta', ['donantes_count' => $donantes->count()]);

        // Retornar la respuesta en formato JSON
        return response()->json([
            'tabla' => $tabla,
            'paginacion' => $paginacion,
        ]);
    }







    public function home()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        $datos['donantes'] = Donante::paginate(10);
        return view('administrador.homeDonante', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        return view('donante.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'cedula' => 'required|digits:8|unique:donantes,cedula', // Cédula única y exactamente 8 dígitos
            'nombre' => 'required|string|max:50', // Nombre obligatorio, texto y máximo 50 caracteres
            'apellido' => 'required|string|max:50', // Apellido obligatorio, texto y máximo 50 caracteres
            'telefono' => 'required|digits_between:7,15', // Teléfono obligatorio, entre 7 y 15 dígitos
            'fecha_nacimiento' => 'required|date|before_or_equal:today', // Fecha de nacimiento obligatoria y no puede ser futura
            'observaciones' => 'nullable|string|max:255', // Observaciones opcionales, máximo 255 caracteres
        ]);

        // Verificar cédula uruguaya
        if (!$this->validarCedulaUruguaya($request->cedula)) {
            return back()->with('error', 'La cédula ingresada no es válida según las reglas uruguayas.')->withInput();
        }

        // Guardar los datos del donante
        $datosDonante = $request->except('_token');
        Donante::create($datosDonante);

        // Redirigir con mensaje de éxito
        return redirect('donante')->with('mensaje', 'Se agregó el donante correctamente.');
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
        if (session('tipo_usuario') !== 'Administrador' && session('tipo_usuario') !== 'Estudiante') {
            abort(403, 'Acceso no autorizado.');
        }

        $donante = Donante::findOrFail($id);
        return view('donante.edit', compact('donante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $datosDonante = request()->except(['_token', '_method']);

        // Verificar cédula uruguaya
        if (!$this->validarCedulaUruguaya($datosDonante['cedula'])) {
            return back()->with('error', 'La cédula ingresada no es válida según las reglas uruguayas.')->withInput();
        }

        // Asignar el usuario actual como modificador
        $datosDonante['modificado_por'] = session('usuario_id');

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


    public function noAsistio($id)
    {
        $donante = Donante::findOrFail($id);

        $agenda = Agenda::where('id_donante', $id)
            ->whereNull('asistio')  // Esto agrega la condición donde 'asistio' es null
            ->orderByDesc('fecha_agenda')
            ->first();

        if ($agenda) {
            $agenda->asistio = false;
            $agenda->save();
        }


        $donante->estado = EstadoDonante::Disponible->value;
        $donante->save();

        return redirect()->route('gestionarDonante', ['id' => $id])
            ->with('mensaje', 'Se actualizo la asistencia del donante');
    }

    public function getDetails($id)
    {
        // Obtiene el donante con los conteos de donaciones y diferimientos
        $donante = Donante::findOrFail($id);

        $donante->donaciones_count = Donacion::where('id_donante', $id)->count();
        $donante->diferimientos_count = Diferimento::where('id_donante', $id)->count();

        $usuario = null;

        if ($donante->modificado_por === null) {
            $donante->modificado_por = 'N/A';
        } else {
            $usuario = Usuario::findOrFail($donante->modificado_por);
        }

        // Devuelve los datos del donante como JSON
        return response()->json([
            'id' => $donante->id,
            'nombre' => $donante->nombre,
            'apellido' => $donante->apellido,
            'cedula' => $donante->cedula,
            'sexo' => $donante->sexo,
            'telefono' => $donante->telefono,
            'fecha_nacimiento' => \Carbon\Carbon::parse($donante->fecha_nacimiento)->format('d/m/Y'),
            'ABO' => $donante->ABO,
            'RH' => $donante->RH,
            'estado' => $donante->estado,
            'observaciones' => $donante->observaciones,
            'donaciones_count' => $donante->donaciones_count, // Conteo de donaciones
            'diferimientos_count' => $donante->diferimientos_count, // Conteo de diferimientos
            'modificado_por' => $usuario ? $usuario->nombre . ' ' . $usuario->apellido : 'N/A', // Nombre del usuario que modificó

        ]);
    }

    public function notificar($id)
    {
        $donante = Donante::findOrFail($id);
        $donante->estado = 'Notificado';
        $donante->modificado_por = session('usuario_id');
        $donante->ultima_modificacion = now();
        $donante->save();

        return redirect()->route('gestionarDonante', ['id' => $id])
            ->with('mensaje', 'Donante notificado correctamente');
    }
}
