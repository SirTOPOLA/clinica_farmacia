<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Sección de Log de Usuarios -->
<div id="logs" class="card p-4 mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-clipboard-data me-2"></i> Historial de Actividades</h4>
    <a href="registrar_log_usuario.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> log
      </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Usuario</th>
        <th>Acción</th>
        <th>Fecha</th>
        <th>IP</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>admin@example.com</td>
        <td>Inicio sesión</td>
        <td>2025-04-24 08:35:12</td>
        <td>192.168.1.10</td>
      </tr>
      <tr>
        <td>2</td>
        <td>medico1@example.com</td>
        <td>Registró una cita médica</td>
        <td>2025-04-24 09:10:42</td>
        <td>192.168.1.15</td>
      </tr>
      <!-- Más registros... -->
    </tbody>
  </table>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
