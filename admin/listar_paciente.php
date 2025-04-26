<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">group</span> Gestión de Pacientes</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_paciente.php'">
          <span class="material-icons"> add</span>
        </button>
      </div>

      <!-- para las elertas -->
   <!-- para las alertas -->
   <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por nombre, código, género, correo..."
                oninput="buscarPacientes()">
            </div>
          </div>
        </div>

        <div id="tabla-pacientes" class="table-responsive">
          <!-- Aquí se cargará la tabla con los pacientes -->
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">fingerprint</span> Código</th>
                <th><span class="material-icons">person</span> Nombre</th>
                <th><span class="material-icons">cake</span> Nacimiento</th>
                <th><span class="material-icons">transgender</span> Género</th>
                <th><span class="material-icons">phone</span> Teléfono</th>
                <th><span class="material-icons">email</span> Correo</th>
                <th><span class="material-icons">home</span> Dirección</th>
                <th><span class="material-icons">date_range</span> Registro</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div id="paginacion" class="d-flex justify-content-center">
          <!-- Los enlaces de paginación se cargarán aquí -->
        </div>
      </div>
    </div>
  </div>
</div>

 

</body>
</html>