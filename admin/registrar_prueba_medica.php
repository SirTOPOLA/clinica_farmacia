<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Registrar Prueba Médica</h5>
      <a href="listar_prueba_medica.php" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left-circle me-1"></i> Volver
      </a>
    </div>

    <div class="card-body">
      <form action="guardar_prueba_medica.php" method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre de la Prueba</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="bi bi-clipboard-pulse"></i></span>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
            <div class="invalid-feedback">Por favor, ingrese el nombre de la prueba.</div>
          </div>
        </div>

        <div class="mb-4">
          <label for="precio" class="form-label">Precio</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
            <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            <div class="invalid-feedback">Por favor, ingrese el precio de la prueba.</div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Guardar
          </button>
          <a href="listar_prueba_medica.php" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
