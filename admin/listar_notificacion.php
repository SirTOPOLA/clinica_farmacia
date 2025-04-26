<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">history</span> Registro de Actividad de Usuarios</h2>
      </div>
 <!-- para las alertas -->
 <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>
      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded"
                     placeholder="🔍 Buscar por acción, IP o usuario..." oninput="buscarLogs()">
            </div>
          </div>
        </div>

        <div id="tabla-logs" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">person</span> Usuario</th>
                <th><span class="material-icons">assignment</span> Acción</th>
                <th><span class="material-icons">event</span> Fecha</th>
                <th><span class="material-icons">public</span> IP</th>
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
