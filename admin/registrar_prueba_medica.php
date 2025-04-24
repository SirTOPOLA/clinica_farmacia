<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     
 <!-- Formulario de Registro de Prueba Médica -->
<div class="container mt-4">
  <div class="card p-4">
    <h4 class="mb-3"><i class="bi bi-plus-circle me-2"></i> Registrar Prueba Médica</h4>
    <form action="guardar_prueba_medica.php" method="POST">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la Prueba</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-save me-1"></i> Guardar
        </button>
        <a href="listar_prueba_medica.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
      </div>
    </form>
  </div>
</div>

</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
