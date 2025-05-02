{{-- filepath: resources/views/donante/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <section class="section__registrar">
        <h2 class="section__registrar-title">Editar Donante</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/donante/' . $donante->id) }}" method="POST" class="registrar__formulario">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <!-- ID oculto -->
            <input type="hidden" id="id" name="id" value="{{ $donante->id }}">

            <div class="contenedor__nombre__completo">
                <div>
                    <label class="block" for="txt__nombre">Nombre</label>
                    <input class="input__div" type="text" name="nombre" id="txt__nombre" required
                        placeholder="Nombre del donante" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        title="El nombre solo puede contener letras y espacios."
                        value="{{ $donante->nombre }}">
                </div>
                <div>
                    <label class="block" for="txt__apellido">Apellido</label>
                    <input class="input__div" type="text" name="apellido" id="txt__apellido" required
                        placeholder="Apellido del donante" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        title="El apellido solo puede contener letras y espacios."
                        value="{{ $donante->apellido }}">
                </div>
            </div>

            <label class="block" for="txt__cedula">Cédula</label>
            <input class="input__div" type="number" name="cedula" id="txt__cedula" required
                placeholder="Cédula del donante" maxlength="20" title="La cédula solo puede contener números."
                value="{{ $donante->cedula }}">

            <label class="block" for="txt__telefono">Teléfono</label>
            <input class="input__div" type="text" name="telefono" id="txt__telefono" required
                placeholder="Teléfono del donante" maxlength="15" pattern="\d{7,15}"
                title="El teléfono debe contener entre 7 y 15 dígitos."
                value="{{ $donante->telefono }}">

            <label class="block" for="txt__fecha">Fecha de nacimiento</label>
            <input class="input__div" type="date" name="fecha_nacimiento" id="txt__fecha" required
                max="{{ date('Y-m-d') }}" title="La fecha de nacimiento no puede ser posterior a hoy."
                value="{{ $donante->fecha_nacimiento }}">

            <label for="txt_sexo" class="block">Sexo:</label>
            <select id="txt_sexo" name="sexo" class="input__div" required>
                <option value="M" {{ $donante->sexo === 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ $donante->sexo === 'F' ? 'selected' : '' }}>Femenino</option>
            </select>

            <div class="contenedor__datos__sangineos">
                <div>
                    <label class="block" for="txt__abo">ABO</label>
                    <select class="input__div" name="ABO" id="txt__abo" required>
                        @foreach (App\Enums\TipoABO::cases() as $tipo)
                            <option value="{{ $tipo->value }}" {{ $donante->ABO === $tipo->value ? 'selected' : '' }}>
                                {{ $tipo->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block" for="txt__rh">RH</label>
                    <select class="input__div" name="RH" id="txt__rh" required>
                        @foreach (App\Enums\TipoRH::cases() as $tipo)
                            <option value="{{ $tipo->value }}" {{ $donante->RH === $tipo->value ? 'selected' : '' }}>
                                {{ $tipo->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <label class="block" for="estado">Estado</label>
            <select class="input__div" name="estado" id="estado" required>
                @foreach (App\Enums\EstadoDonante::cases() as $tipo)
                    <option value="{{ $tipo->value }}" {{ $donante->estado === $tipo->value ? 'selected' : '' }}>
                        {{ $tipo->value }}
                    </option>
                @endforeach
            </select>

            <label class="block" for="observaciones">Observaciones</label>
            <textarea class="input__div" id="observaciones" name="observaciones" rows="3"
                placeholder="Escriba sus observaciones...">{{ $donante->observaciones }}</textarea>

            <div class="contenedor__bottom">
                
                    
                        <a href="{{ route('donante.index') }}" type="button"
                            class="contenedor__descripcion__porque cancelar">Volver</a>
                        <button type="submit" class="contenedor__descripcion__porque guardar">Guardar</button>
                    
                
            </div>

            @if (session('mensaje'))
                <div class="alert alert-success mt-3">
                    {{ session('mensaje') }}
                </div>
            @endif
        </form>
    </section>
@endsection
