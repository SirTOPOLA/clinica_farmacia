<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Sección de Citas -->
<div id="citas" class="card p-4 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Listado de Citas</h4>
    <a href="registrar_cita.php" class="btn btn-primary">
      <i class="bi bi-calendar-plus me-1"></i> Registrar Cita
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Empleado</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>Dra. Ana López</td>
        <td>2025-05-10</td>
        <td>10:00</td>
        <td><span class="badge bg-warning text-dark">Pendiente</span></td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>María García</td>
        <td>Dr. Carlos Ruiz</td>
        <td>2025-05-11</td>
        <td>14:30</td>
        <td><span class="badge bg-success">Confirmada</span></td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
