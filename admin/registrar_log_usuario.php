<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Registrar Log de Usuario -->
<div id="registrar-log" class="card p-4 mt-4">
  <h4 class="mb-4"><i class="bi bi-pencil-square me-2"></i> Registrar Log de Usuario</h4>
  <form>
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario (ID o correo)</label>
      <input type="text" class="form-control" id="usuario" placeholder="Ej: admin@example.com">
    </div>

    <div class="mb-3">
      <label for="accion" class="form-label">Acción realizada</label>
      <textarea class="form-control" id="accion" rows="3" placeholder="Describa la acción realizada..."></textarea>
    </div>

    <div class="mb-3">
      <label for="ip" class="form-label">IP del usuario</label>
      <input type="text" class="form-control" id="ip" placeholder="Ej: 192.168.0.1">
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="bi bi-save me-1"></i> Guardar Log
    </button>
  </form>
</div>

 
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
