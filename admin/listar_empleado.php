<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
 
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header">
        <div class="d-flex flex-sm-row justify-content-between align-items-center bg-primary text-white p-4 rounded-top">
          <h2 class="mb-0"><span class="material-icons">group</span> Gestión de Empleados</h2>
          <button class="btn btn-primary text-white shadow-sm rounded-3 p-2"
            onclick="window.location='registrar_empleado.php'">
            <span class="material-icons"> add</span>Registrar
          </button>
        </div>
        <div class="d-flex justify-content-center pt-4">
          <div class="col-12 col-md-6">
            <input type="text" id="buscar" class="form-control shadow-sm form-control-lg"
              placeholder="🔍 Buscar por nombre, código, correo..." contenteditable="true">
          </div> 
        </div>
      </div>

      <!-- Alertas -->
      <div id="alert-container" class="container">
        <?php include_once "../components/alerta.php"; ?>
      </div>

      <div class="card-body bg-light">
        <div id="table-responsive" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="p-3 text-white">
              <tr>
                <th><span class="material-icons">code</span> ID</th>
                <th><span class="material-icons">fingerprint</span> Código</th>
                <th><span class="material-icons">person</span> Nombre</th>
                <th><span class="material-icons">person</span> Apellidos</th>
                <th><span class="material-icons">email</span> Correo</th>
                <th><span class="material-icons">phone</span> Teléfono</th>
                <th><span class="material-icons">home</span> Dirección</th>
                <th><span class="material-icons">access_time</span> Horario</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody id="tabla-body">
              <!-- Aquí se generarán los empleados con JS -->
            </tbody>
          </table>
        </div>

        
        <!-- Paginación -->
        <nav id="paginacion" aria-label="Paginación de empleados" class="d-flex justify-content-center mt-4">
          
        </nav>
         
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/empleados.js"></script>
<script src="../assets/js/sidebar.js"></script>
<script src="../assets/js/alerta.js"></script>
 
</body>

</html>