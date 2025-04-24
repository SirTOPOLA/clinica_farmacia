<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     
 <!-- Sección de Tratamientos -->
<div id="tratamientos" class="card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Lista de Tratamientos</h4>
    <a href="registrar_tratamiento.php" class="btn btn-primary">
      <i class="bi bi-plus-circle-fill me-1"></i> Registrar Tratamiento
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Médico</th>
        <th>Descripción</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>Dra. Ana Ruiz</td>
        <td>Tratamiento antibiótico por infección urinaria</td>
        <td>2025-04-20</td>
        <td>2025-04-27</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>María López</td>
        <td>Dr. Luis Méndez</td>
        <td>Terapia respiratoria post-COVID</td>
        <td>2025-04-22</td>
        <td>2025-05-06</td>
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
