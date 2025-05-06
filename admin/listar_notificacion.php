<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">notifications</span> Notificaciones</h2>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded"
                     placeholder="🔍 Buscar por mensaje o tipo..." oninput="buscarNotificaciones()">
            </div>
          </div>
        </div>

        <div id="tabla-notificaciones" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">message</span> Mensaje</th>
                <th><span class="material-icons">date_range</span> Fecha de Creación</th>
                <th><span class="material-icons">notifications_active</span> Tipo</th>
                <th><span class="material-icons">check_circle</span> Leído</th>
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
