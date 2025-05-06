<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-info text-white rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-flask me-2"></i> Registrar Resultado de Laboratorio</h5>
    </div>

    <div class="card-body">
      <form class="needs-validation" method="POST" action="../php/insertar_pruebas.php" novalidate>
        <div class="mb-3">
          <label for="tipo_estudio" class="form-label">Nombre de la Prueba Médica</label>
          <input type="text" class="form-control" id="tipo_estudio" name="nombre" placeholder="Ej: Hemograma completo" required>
          <div class="invalid-feedback">Debe especificar el nombre de la prueba.</div>
        </div>

        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" step="0.01" class="form-control" id="precio" name="precio" min="0" placeholder="Ej: 25.50" required>
          <div class="invalid-feedback">Debe indicar el precio.</div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-save me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS y validación -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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