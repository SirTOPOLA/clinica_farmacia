<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Sección: Lista de Recetas Médicas -->
<div class="card p-4" id="listarRecetas">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Lista de Recetas</h4>
    <a href="registrar_receta.php" class="btn btn-primary">
      <i class="bi bi-prescription2 me-1"></i> Nueva Receta
    </a>
  </div>
  <table class="table table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Paciente</th>
        <th>Médico</th>
        <th>Fecha</th>
        <th>Medicamento</th>
        <th>Dosis</th>
        <th>Duración</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>Dra. Ana Ruiz</td>
        <td>2025-04-20</td>
        <td>Amoxicilina</td>
        <td>500mg cada 8h</td>
        <td>7 días</td>
        <td>
          <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
      <tr>
        <td>2</td>
        <td>María García</td>
        <td>Dr. Luis Méndez</td>
        <td>2025-04-22</td>
        <td>Ibuprofeno</td>
        <td>400mg cada 6h</td>
        <td>5 días</td>
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
