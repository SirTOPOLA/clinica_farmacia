<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">monitor_heart</span> Registros de Triaje</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_triaje.php'">
          <span class="material-icons">add</span> 
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
              <input type="text" id="buscar" class="form-control shadow-sm rounded"
                     placeholder="🔍 Buscar por nombre de paciente o fecha..."
                     oninput="buscarTriaje()">
            </div>
          </div>
        </div>

        <div id="tabla-triaje" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-dark text-white">
              <tr>
                <th><span class="material-icons">person</span> Paciente</th>
                <th><span class="material-icons">event</span> Fecha</th>
                <th><span class="material-icons">schedule</span> Hora</th>
                <th><span class="material-icons">favorite</span> Pulso</th>
                <th><span class="material-icons">thermostat</span> Temp (°C)</th>
                <th><span class="material-icons">monitor_weight</span> Peso (kg)</th>
                <th><span class="material-icons">bloodtype</span> Presión</th>
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
