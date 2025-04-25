<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Sección de Historial Médico -->
<div id="historiales" class="card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Historial Médico</h4>
    <a href="registrar_historial_medico.php" class="btn btn-primary">
      <i class="bi bi-journal-plus"></i> Registrar Historial
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Empleado</th>
        <th>Fecha</th>
        <th>Diagnóstico</th>
        <th>Tratamiento</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>Dra. Ana Ruiz</td>
        <td>2025-04-22</td>
        <td>Migraña</td>
        <td>Analgésicos y descanso</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>María García</td>
        <td>Dr. Luis Méndez</td>
        <td>2025-04-20</td>
        <td>Bronquitis</td>
        <td>Antibióticos y reposo</td>
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
