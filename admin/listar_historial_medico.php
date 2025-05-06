<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">history_edu</span> Historial Médico</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_historial.php'">
          <span class="material-icons"> add</span> 
        </button>
      </div>

     <!-- para las alertas -->
     <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por paciente, empleado o diagnóstico..."
                oninput="buscarHistorial()">
            </div>
          </div>
        </div>

        <div id="tabla-historial" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">person</span> Paciente</th>
                <th><span class="material-icons">medical_services</span> Empleado</th>
                <th><span class="material-icons">event</span> Fecha</th>
                <th><span class="material-icons">description</span> Descripción</th>
                <th><span class="material-icons">fact_check</span> Diagnóstico</th>
                <th><span class="material-icons">healing</span> Tratamiento</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>
 
</body>
</html>
