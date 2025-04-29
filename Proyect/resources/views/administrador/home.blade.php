@extends('layouts.admin')

@section('contentAdmin')

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
      <!-- Select para Ordenado por -->
      <select name="cmb__ordenado_por" id="cmb__ordenado__por" class="select">
        <option value="" disabled selected>Ordenado por</option>
        <option value="Mes">Mes</option>
        <option value="Año">Año</option>
        <option value="Edad">Edad</option>
      </select>

      <!-- Select para Sexo -->
      <select name="cmb__sexo" id="cmb__sexo" class="select">
        <option value="" disabled selected>Sexo</option>
        @foreach (App\Enums\Sexo::cases() as $sexo)
        <option value="{{ $sexo->value }}">{{ $sexo->value }}</option>
        @endforeach
      </select>

      <!-- Select para Estado -->
      <select name="cmb__estado" id="cmb__estado" class="select">
        <option value="" disabled selected>Estado</option>
        @foreach (App\Enums\EstadoDonante::cases() as $estado)
        <option value="{{ $estado->value }}">{{ $estado->value }}</option>
        @endforeach
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
        <tr class="fila-usuario">
          <td>Luis</td>
          <td>Alberto</td>
          <td>5672492</td>
          <td>0+</td>
          <td>tf</td>
          <td>10/10/10</td>
          <td>M</td>
          <td><a href=""><img src="{{ asset('imgs/edit_icon.png') }}" alt=""></a></td>
          <td><a href=""><img src="{{ asset('imgs/ver_mas_icon.png') }}" alt=""></a></td>
          <td><a href=""><img src="{{ asset('imgs/gestionar_icon.png') }}" alt=""></a></td>
          <td><span class="estado">Estado</span></td>
        </tr>
      </tbody>
    </table>
    <div class="pagination" id="pagination"></div>
  </div>

  <div class="content__main__bottom">
    <a href="" id="btn__Registrar" class="btn__bottom">Gestionar donante</a>
    <a href="{{route ('administrador.index') }}" id="btn__Registrar" class="btn__bottom">Gestionar usuario</a>
    <div class="contenedor__bottom__div">
      <a href="{{route ('administrador.create') }}" id="btn__Registrar" class="btn__bottom usuario">Registrar usuario</a>
    </div>
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