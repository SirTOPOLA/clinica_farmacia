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
      <form class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="paciente" class="form-label">Paciente</label>
          <select class="form-select" id="paciente" required>
            <option selected disabled value="">Seleccione un paciente</option>
            <option value="1">Juan Pérez</option>
            <option value="2">María Gómez</option>
          </select>
          <div class="invalid-feedback">Seleccione un paciente válido.</div>
        </div>

        <div class="mb-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha" required>
          <div class="invalid-feedback">Debe indicar la fecha del estudio.</div>
        </div>

        <div class="mb-3">
          <label for="tipo_estudio" class="form-label">Tipo de Estudio</label>
          <input type="text" class="form-control" id="tipo_estudio" placeholder="Ej: Hemograma completo" required>
          <div class="invalid-feedback">Debe especificar el tipo de estudio.</div>
        </div>

        <div class="mb-3">
          <label for="resultado" class="form-label">Resultado</label>
          <textarea class="form-control" id="resultado" rows="3" placeholder="Describa el resultado..." required></textarea>
          <div class="invalid-feedback">Debe proporcionar el resultado del estudio.</div>
        </div>

        <div class="mb-3">
          <label for="observaciones" class="form-label">Observaciones</label>
          <textarea class="form-control" id="observaciones" rows="2" placeholder="Opcional: comentarios del profesional..."></textarea>
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
<<script src="../assets/js/bootstrap.bundle.min.js"></script>
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
