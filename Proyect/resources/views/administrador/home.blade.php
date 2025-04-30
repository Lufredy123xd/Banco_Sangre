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
        
        
            <select name="cmb__estado" id="cmb__estado" class="select">
                <option value="" disabled selected>Estado</option>
                @foreach (App\Enums\EstadoUsuario::cases() as $estado)
                    <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                @endforeach
            </select>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                
                const estadoSelect = document.getElementById("cmb__estado");
                
                const rows = Array.from(document.querySelectorAll(".fila-usuario"));
        
                function filterTable() {
                   
                    const selectedEstado = estadoSelect.value;
                  
        
                    rows.forEach(row => {
                        
                        const estado = row.querySelector(".estado").textContent.trim();
                        const nombre = row.querySelector("td:nth-child(2)").textContent.trim();
        
                        
                        let matchesEstado = !selectedEstado || estado === selectedEstado;
        
                        row.style.display = matchesEstado ? "table-row" : "none";
                    });
        
                    if (selectedOrdenadoPor) {
                        rows.sort((a, b) => {
                            const aValue = a.querySelector(`td:nth-child(${getColumnIndex(selectedOrdenadoPor)})`).textContent.trim();
                            const bValue = b.querySelector(`td:nth-child(${getColumnIndex(selectedOrdenadoPor)})`).textContent.trim();
                            return aValue.localeCompare(bValue);
                        }).forEach(row => row.parentElement.appendChild(row));
                    }
                }
        
                function getColumnIndex(columnName) {
                    switch (columnName) {
                        case "nombre": return 2;
                        case "cedula": return 3;
                        case "tipo_usuario": return 4;
                        default: return 1;
                    }
                }
        
             
                estadoSelect.addEventListener("change", filterTable);
                
            });
        </script>





    </div>

    <div class="content__main__center">
    <table>
      <thead>
        <tr>
          <th>id</th>
          <th>Nombre</th>
          <th>CI</th>
          <th>Tipo deusuario</th>
          <th></th>
          <th></th>
          <th></th>
          <th>Editar</th>
          <th>Ver más</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($usuarios as $usuario)
        <tr class="fila-usuario">
          <td>{{ $usuario->id }}</td>
          <td>{{ $usuario->nombre }}</td>
          <td>{{ $usuario->cedula }}</td>
          <td>{{ $usuario->tipo_usuario }}</td>
          <td></td>
          <td></td>
          <td></td>
          <td><a href="{{ url('/administrador/' . $usuario->id . '/edit') }}"><img src="{{ asset('imgs/edit_icon.png') }}" alt=""></a></td>
          <td><a href="{{ route('administrador.verMas', ['id' => $usuario->id]) }}"><img src="{{ asset('imgs/ver_mas_icon.png') }}" alt=""></a></td>
          <td><span class="estado {{ strtolower($usuario->estado) }}">{{ $usuario->estado }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination" id="pagination"></div>
</div>

    <div class="content__main__bottom">
    <a  href="{{route ('administrador.homeDonante')}}" id="btn__Registrar" class="btn__bottom">Gestionar donante</a>
    <a  href="{{route ('administrador.home') }}" id="btn__Registrar" class="btn__bottom">Gestionar usuario</a>
    <div class="contenedor__bottom__div">
        <a  href="{{route ('administrador.create') }}" id="btn__Registrar" class="btn__bottom usuario">Registrar usuario</a>
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