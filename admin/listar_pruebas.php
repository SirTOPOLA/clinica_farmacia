<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">science</span> Pruebas Médicas</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_prueba.php'">
          <span class="material-icons">add</span>
        </button>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar prueba médica..." oninput="buscarPruebas()">
            </div>
          </div>
        </div>

        <div id="tabla-pruebas" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-dark text-white">
              <tr>
                <th><span class="material-icons">label</span> Nombre</th>
                <th><span class="material-icons">payments</span> Precio (XAF/)</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody id="tabla-body"></tbody>
          </table>
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>

<script>
  // Función para realizar la búsqueda
  function buscarPruebas() {
    var search = document.getElementById('buscar').value;

    // Hacer la solicitud AJAX
    $.ajax({
      url: 'pruebas_medicas.php',
      method: 'GET',
      data: {
        search: search,
        page: 1 // Queremos que la búsqueda se haga desde la página 1
      },
      success: function(response) {
        // Verificamos si hay un error en la respuesta
        var data = JSON.parse(response);
        
        if (data.error) {
          alert('Error: ' + data.error);
          return;
        }

        // Mostrar los resultados en la tabla
        mostrarTabla(data.pruebas);

        // Mostrar la paginación
        mostrarPaginacion(data.totalPages, data.currentPage);
      },
      error: function() {
        alert('Ocurrió un error al intentar obtener los datos.');
      }
    });
  }

  // Función para mostrar la tabla
  function mostrarTabla(pruebas) {
    var tablaBody = document.getElementById('tabla-body');
    tablaBody.innerHTML = ''; // Limpiar la tabla antes de mostrar los nuevos datos

    if (pruebas.length === 0) {
      tablaBody.innerHTML = '<tr><td colspan="3" class="text-center">No se encontraron resultados.</td></tr>';
      return;
    }

    pruebas.forEach(function(prueba) {
      var row = document.createElement('tr');
      row.innerHTML = `
        <td>${prueba.nombre}</td>
        <td>${prueba.precio} XAF/</td>
        <td>
          <a href="editar_prueba.php?id=${prueba.id_prueba}" class="btn btn-warning btn-sm">
            <span class="material-icons">edit</span> Editar
          </a>
          <a href="eliminar_prueba.php?id=${prueba.id_prueba}" class="btn btn-danger btn-sm">
            <span class="material-icons">delete</span> Eliminar
          </a>
        </td>
      `;
      tablaBody.appendChild(row);
    });
  }

  // Función para mostrar la paginación
  function mostrarPaginacion(totalPages, currentPage) {
    var paginacion = document.getElementById('paginacion');
    paginacion.innerHTML = ''; // Limpiar la paginación antes de mostrarla

    for (var i = 1; i <= totalPages; i++) {
      var pageItem = document.createElement('li');
      pageItem.classList.add('page-item');
      if (i === currentPage) {
        pageItem.classList.add('active');
      }

      pageItem.innerHTML = `
        <a class="page-link" href="#" onclick="cambiarPagina(${i})">${i}</a>
      `;
      paginacion.appendChild(pageItem);
    }
  }

  // Función para cambiar la página
  function cambiarPagina(page) {
    var search = document.getElementById('buscar').value;

    $.ajax({
      url: 'pruebas_medicas.php',
      method: 'GET',
      data: {
        search: search,
        page: page
      },
      success: function(response) {
        var data = JSON.parse(response);
        
        // Mostrar los resultados en la tabla
        mostrarTabla(data.pruebas);

        // Mostrar la paginación
        mostrarPaginacion(data.totalPages, data.currentPage);
      },
      error: function() {
        alert('Ocurrió un error al intentar obtener los datos.');
      }
    });
  }

  // Al cargar la página, buscamos todos los registros por defecto
  window.onload = function() {
    buscarPruebas();
  };
</script>

</body>
</html>


