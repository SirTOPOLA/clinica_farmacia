<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-warning text-dark rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-bell-fill me-2"></i> Registrar Notificación</h5>
    </div>

    <div class="card-body">
      <form class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="mensaje" class="form-label">Mensaje</label>
          <div class="input-group has-validation">
            <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
            <textarea class="form-control" id="mensaje" rows="3" placeholder="Escriba el mensaje..." required></textarea>
            <div class="invalid-feedback">El mensaje no puede estar vacío.</div>
          </div>
        </div>

        <div class="mb-3">
          <label for="tipo" class="form-label">Tipo</label>
          <select class="form-select" id="tipo" required>
            <option value="" disabled selected>Seleccione tipo</option>
            <option value="caducidad_medicamento">Caducidad de Medicamento</option>
            <option value="recordatorio_cita">Recordatorio de Cita</option>
          </select>
          <div class="invalid-feedback">Seleccione un tipo de notificación.</div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-check-circle me-1"></i> Registrar Notificación
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS y validación -->
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
