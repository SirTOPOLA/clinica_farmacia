<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     
 <!-- Sección de Pruebas Médicas -->
<div class="container mt-4">
  <div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0"><i class="bi bi-clipboard2-pulse me-2"></i> Lista de Pruebas Médicas</h4>
      <a href="registrar_prueba_medica.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Registrar Prueba Médica
      </a>
    </div>
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Hemograma completo</td>
          <td>35.00</td>
          <td>
            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Electrocardiograma</td>
          <td>50.00</td>
          <td>
            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
