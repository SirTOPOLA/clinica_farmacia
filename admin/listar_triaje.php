<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Sección de Triaje -->
<div id="triaje" class="card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Registros de Triaje</h4>
    <a href="registrar_triaje.php" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Registrar Triaje
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Usuario</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Pulso</th>
        <th>Temperatura (°C)</th>
        <th>Peso (kg)</th>
        <th>Presión Arterial</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>Enfermera 1</td>
        <td>2025-04-24</td>
        <td>09:00</td>
        <td>72</td>
        <td>36.5</td>
        <td>70.50</td>
        <td>120/80</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <!-- Más filas si deseas -->
    </tbody>
  </table>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
