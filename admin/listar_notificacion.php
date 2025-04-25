<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     
  <div class="card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Notificaciones</h4>
    <a href="registrar_notificacion.php" class="btn btn-primary">
      <i class="bi bi-plus-circle-fill me-1"></i> Registrar Tratamiento
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Mensaje</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>El medicamento Paracetamol está próximo a caducar.</td>
        <td>2025-04-23 10:00</td>
        <td>Caducidad de Medicamento</td>
        <td><span class="badge bg-warning text-dark">No leído</span></td>
        <td>
          <button class="btn btn-sm btn-success"><i class="bi bi-check2-square"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>Recordatorio: cita médica de Juan Pérez mañana a las 10:00.</td>
        <td>2025-04-22 08:30</td>
        <td>Recordatorio de Cita</td>
        <td><span class="badge bg-secondary">Leído</span></td>
        <td>
          <button class="btn btn-sm btn-success"><i class="bi bi-check2-square"></i></button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
