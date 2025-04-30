@extends('layouts.app')
@section('content')

<div class="content__main">
    <div class="content__main__top">
        <form action="" method="post">
            <input type="text" name="txt_buscar" id="txt_buscar" class="content__main__top-text" placeholder="Ingrese dato a buscar">
            <button class="content__main__top-button">Buscar</button>
        </form>
        <div class="dropdown-checkboxes">
            <button class="dropdown-toggle">Filtrar columnas ▾</button>
            <div class="dropdown-menu">
                <label><input type="checkbox" name="cedula"> Cédula</label>
                <label><input type="checkbox" name="nombre"> Nombre</label>
                <label><input type="checkbox" name="apellido"> Apellido</label>
                <label><input type="checkbox" name="telefono"> Teléfono</label>
                <label><input type="checkbox" name="fechaNacimiento"> Fecha de Nacimiento</label>
                <label><input type="checkbox" name="ABO"> ABO</label>
                <label><input type="checkbox" name="RH"> RH</label>
                <label><input type="checkbox" name="ultimaFechaDonacion"> Última Fecha de Donación</label>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const dropdown = document.querySelector(".dropdown-checkboxes");
                const toggleBtn = dropdown.querySelector(".dropdown-toggle");

                toggleBtn.addEventListener("click", function() {
                    dropdown.classList.toggle("open");
                });

                document.addEventListener("click", function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove("open");
                    }
                });
            });
        </script>


        <div class="main__select">
            <select name="cmb__ordenado_por" id="cmb__ordenado__por" class="select">
                <option value="1" disabled selected>Ordenado por</option>
                <option value="2">Mes</option>
                <option value="2">Año</option>
                <option value="2">Edad</option>
            </select>

            <select name="cmb__sexo" id="cmb__sexo" class="select">
                <option value="1" disabled selected>Sexo</option>
                <option value="2">Mes</option>
                <option value="2">Año</option>
                <option value="2">Edad</option>
            </select>

            <select name="cmb__estado" id="cmb__estado" class="select">
                <option value="1" disabled selected>Estado</option>
                <option value="2">Mes</option>
                <option value="2">Año</option>
                <option value="2">Edad</option>
            </select>
        </div>
    </div>

    <div class="content__main__center">
    <table>
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
        @foreach ( $donantes as $donante )
        
        <tr class="fila-usuario">
          <td>{{ $donante->nombre }}</td>
          <td>{{ $donante->apellido }}</td>
          <td>{{ $donante->cedula }}</td>
          <td>{{ $donante->ABO }}</td>
          <td>{{ $donante->RH }}</td>
          <td>
            {{ $donante->donaciones->sortByDesc('fecha')->first() ? $donante->donaciones->sortByDesc('fecha')->first()->fecha : 'Sin donaciones' }}
         </td>
          <td>{{ $donante->sexo }}</td>
          <td><a href="{{ url('/donante/' . $donante->id . '/edit') }}"><img src="imgs/edit_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/ver_mas_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/gestionar_icon.png" alt=""></a></td>
          <td><span class="estado">{{ $donante->estado }}</span></td>
          
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
  const rowsPerPage = 2; // Cambia esto para mostrar más/menos por página
  const table = document.querySelector("table");
  const tbody = table.querySelector("tbody");
  const rows = Array.from(tbody.querySelectorAll("tr"));
  const pagination = document.getElementById("pagination");

  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "table-row" : "none";
    });

    updatePagination(page);
  }

  function updatePagination(currentPage) {
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    pagination.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.innerText = i;
      if (i === currentPage) btn.classList.add("active");
      btn.addEventListener("click", () => showPage(i));
      pagination.appendChild(btn);
    }
  }

  // Init
  showPage(1);
</script>
@endsection