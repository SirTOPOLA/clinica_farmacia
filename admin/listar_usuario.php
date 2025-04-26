<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">admin_panel_settings</span> Gestión de Usuarios</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_usuario.php'">
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
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por correo, código o rol..."
                oninput="buscarUsuarios()">
            </div>
          </div>
        </div>

        <div id="tabla-usuarios" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">badge</span> Código</th>
                <th><span class="material-icons">mail</span> Correo</th>
                <th><span class="material-icons">security</span> Rol</th>
                <th><span class="material-icons">toggle_on</span> Estado</th>
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
