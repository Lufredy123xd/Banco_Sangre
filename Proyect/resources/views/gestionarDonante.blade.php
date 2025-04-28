@extends('layouts.app')

@section('content')

<div class="content__main">
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
          <td><a href=""><img src="imgs/edit_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/ver_mas_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/gestionar_icon.png" alt=""></a></td>
          <td><span class="estado">Estado</span></td>
        </tr>

        <tr class="fila-usuario">
          <td>Mario</td>
          <td>Alberto</td>
          <td>5672492</td>
          <td>0+</td>
          <td>tf</td>
          <td>10/10/10</td>
          <td>M</td>
          <td><a href=""><img src="imgs/edit_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/ver_mas_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/gestionar_icon.png" alt=""></a></td>
          <td><span class="estado">Estado</span></td>
        </tr>

        <tr class="fila-usuario">
          <td>Alberto</td>
          <td>Alberto</td>
          <td>5672492</td>
          <td>0+</td>
          <td>tf</td>
          <td>10/10/10</td>
          <td>M</td>
          <td><a href=""><img src="imgs/edit_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/ver_mas_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/gestionar_icon.png" alt=""></a></td>
          <td><span class="estado">Estado</span></td>
        </tr>

        <tr class="fila-usuario">
          <td>Pepe</td>
          <td>Alberto</td>
          <td>5672492</td>
          <td>0+</td>
          <td>tf</td>
          <td>10/10/10</td>
          <td>M</td>
          <td><a href=""><img src="imgs/edit_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/ver_mas_icon.png" alt=""></a></td>
          <td><a href=""><img src="imgs/gestionar_icon.png" alt=""></a></td>
          <td><span class="estado">Estado</span></td>
        </tr>
      </tbody>
    </table>
</div>


@endsection