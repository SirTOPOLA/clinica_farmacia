<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
    <div class="card-header">
        <div class="d-flex flex-sm-row justify-content-between align-items-center bg-primary text-white p-4 rounded-top">
          <h2 class="mb-0"><span class="material-icons">group</span> Gestión de Empleados</h2>
          <button class="btn btn-primary text-white shadow-sm rounded-3 p-2"
            onclick="window.location='registrar_usuario.php'">
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

     <!-- para las alertas -->
     <div id="alert-container" class="mb-3">
        <?php include_once("../components/alerta.php"); ?>
      </div>

      
          
       

        <div id="tabla-usuarios" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">code</span> ID</th>
                <th><span class="material-icons">badge</span> Código</th>
                <th><span class="material-icons">mail</span> Correo</th>
                <th><span class="material-icons">security</span> Rol</th>
                <th><span class="material-icons">toggle_on</span> Estado</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody id="tabla-body" ></tbody>
          </table>
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>

<<<<<<< HEAD
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarDesactivar(idUsuario) {
    if (confirm("¿Estás seguro de que deseas desactivar este usuario?")) {
        window.location.href = '../php/desactivar_usuario.php?id_usuario=' + idUsuario;
    }
}

function confirmarActivar(idUsuario) {
    if (confirm("¿Estás seguro de que deseas activar este usuario?")) {
        window.location.href = '../php/activar_usuario.php?id_usuario=' + idUsuario;
    }
}

function editarUsuario(idUsuario) {
    window.location.href = 'editar_usuario.php?id_usuario=' + idUsuario;
}
</script>



=======
 <script src="../assets/js/usuarios.js"></script>
 <script src="../assets/js/alerta.js"></script>
</body>
</html>
>>>>>>> e6c151e7d07453c770ab3d5f051babbc08b02800
