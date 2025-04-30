@extends('layouts.app')
@section('content')

<div class="content__main">
    <div class="content__main__top">
        <form action="javascript:void(0);" method="post">
            <input type="text" name="txt_buscar" id="txt_buscar" class="content__main__top-text" placeholder="Ingrese dato a buscar">
            <button class="content__main__top-button" id="btn_buscar">Buscar</button>
        </form>

        <div class="main__select">
            <select name="cmb__estado" id="cmb__estado" class="select">
                <option value="" selected>Estado</option>
                @foreach (App\Enums\EstadoDonante::cases() as $estado)
                    <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                @endforeach
            </select>

            <select name="cmb__sexo" id="cmb__sexo" class="select">
                <option value="" selected>Sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>

            <select name="cmb__abo" id="cmb__abo" class="select">
                <option value="" selected>ABO</option>
                @foreach (App\Enums\TipoABO::cases() as $abo)
                    <option value="{{ $abo->value }}">{{ $abo->value }}</option>
                @endforeach
            </select>

            <select name="cmb__rh" id="cmb__rh" class="select">
                <option value="" selected>RH</option>
                @foreach (App\Enums\TipoRH::cases() as $rh)
                    <option value="{{ $rh->value }}">{{ $rh->value }}</option>
                @endforeach
            </select>

            <!-- Combo box para ordenar -->
            <select name="cmb__ordenar" id="cmb__ordenar" class="select">
                <option value="" selected>Ordenar por</option>
                <option value="nombre">Nombre</option>
                <option value="apellido">Apellido</option>
                <option value="cedula">Cédula</option>
                <option value="fecha">Última Fecha Donación</option>
            </select>

            <select name="cmb__orden" id="cmb__orden" class="select">
                <option value="asc" selected>Ascendente</option>
                <option value="desc">Descendente</option>
            </select>
        </div>
    </div>

    <div class="content__main__center">
        <table id="donantesTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>CI</th>
                    <th>ABO</th>
                    <th>RH</th>
                    <th>Ultima Fecha Donación</th>
                    <th>Sexo</th>
                    <th>Editar</th>
                    <th>Ver más</th>
                    <th>Gestionar donación</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donantes as $donante)
                <tr class="fila-usuario">
                    <td class="nombre">{{ $donante->nombre }}</td>
                    <td class="apellido">{{ $donante->apellido }}</td>
                    <td class="cedula">{{ $donante->cedula }}</td>
                    <td class="abo">{{ $donante->ABO }}</td>
                    <td class="rh">{{ $donante->RH }}</td>
                    <td class="fecha">
                        {{ $donante->donaciones->sortByDesc('fecha')->first() ? $donante->donaciones->sortByDesc('fecha')->first()->fecha : 'Sin donaciones' }}
                    </td>
                    <td class="sexo">{{ $donante->sexo }}</td>
                    <td><a href="{{ url('/donante/' . $donante->id . '/edit') }}"><img src="imgs/edit_icon.png" alt=""></a></td>
                    <td><a href=""><img src="imgs/ver_mas_icon.png" alt=""></a></td>
                    <td><a href=""><img src="imgs/gestionar_icon.png" alt=""></a></td>
                    <td class="estado">{{ $donante->estado }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination" id="pagination"></div>
    </div>

    <div class="content__main__bottom">
        <a href="{{ route('donante.create') }}" id="btn__Registrar" class="btn__bottom">Registrar Donante</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const estadoFilter = document.getElementById("cmb__estado");
        const sexoFilter = document.getElementById("cmb__sexo");
        const aboFilter = document.getElementById("cmb__abo");
        const rhFilter = document.getElementById("cmb__rh");
        const searchInput = document.getElementById("txt_buscar");
        const ordenarSelect = document.getElementById("cmb__ordenar");
        const ordenSelect = document.getElementById("cmb__orden");
        const rows = document.querySelectorAll(".fila-usuario");

        function filterTable() {
            const estadoValue = estadoFilter.value.toLowerCase();
            const sexoValue = sexoFilter.value.toLowerCase();
            const aboValue = aboFilter.value.toLowerCase();
            const rhValue = rhFilter.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const estado = row.querySelector(".estado").textContent.toLowerCase();
                const sexo = row.querySelector(".sexo").textContent.toLowerCase();
                const abo = row.querySelector(".abo").textContent.toLowerCase();
                const rh = row.querySelector(".rh").textContent.toLowerCase();
                const nombre = row.querySelector(".nombre").textContent.toLowerCase();
                const apellido = row.querySelector(".apellido").textContent.toLowerCase();
                const cedula = row.querySelector(".cedula").textContent.toLowerCase();

                const matchesEstado = !estadoValue || estado === estadoValue;
                const matchesSexo = !sexoValue || sexo === sexoValue;
                const matchesAbo = !aboValue || abo === aboValue;
                const matchesRh = !rhValue || rh === rhValue;
                const matchesSearch = !searchValue || nombre.includes(searchValue) || apellido.includes(searchValue) || cedula.includes(searchValue);

                if (matchesEstado && matchesSexo && matchesAbo && matchesRh && matchesSearch) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function sortTable() {
            const column = ordenarSelect.value;
            const ascending = ordenSelect.value === "asc";
            const tbody = document.querySelector("#donantesTable tbody");
            const rowsArray = Array.from(rows);

            rowsArray.sort((a, b) => {
                const aText = a.querySelector(`.${column}`).textContent.trim().toLowerCase();
                const bText = b.querySelector(`.${column}`).textContent.trim().toLowerCase();

                if (column === "fecha") {
                    return ascending
                        ? new Date(aText) - new Date(bText)
                        : new Date(bText) - new Date(aText);
                }

                return ascending
                    ? aText.localeCompare(bText)
                    : bText.localeCompare(aText);
            });

            rowsArray.forEach(row => tbody.appendChild(row));
        }

        estadoFilter.addEventListener("change", filterTable);
        sexoFilter.addEventListener("change", filterTable);
        aboFilter.addEventListener("change", filterTable);
        rhFilter.addEventListener("change", filterTable);
        searchInput.addEventListener("input", filterTable);
        ordenarSelect.addEventListener("change", sortTable);
        ordenSelect.addEventListener("change", sortTable);
    });
</script>
@endsection