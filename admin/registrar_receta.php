<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-journal-medical me-2"></i> Registrar Nueva Receta</h5>
      <a href="listar_recetas.php" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left-circle me-1"></i> Volver
      </a>
    </div>

    <div class="card-body">
      <form action="#" method="POST" class="needs-validation" novalidate>
        <div class="row g-4 mb-3">
          <div class="col-md-6">
            <label for="paciente" class="form-label">Paciente</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <select class="form-select" id="paciente" name="paciente" required>
                <option selected disabled value="">Seleccione un paciente</option>
                <option value="1">Juan Pérez</option>
                <option value="2">María García</option>
              </select>
              <div class="invalid-feedback">Seleccione un paciente.</div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="medico" class="form-label">Médico</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
              <select class="form-select" id="medico" name="medico" required>
                <option selected disabled value="">Seleccione un médico</option>
                <option value="1">Dra. Ana Ruiz</option>
                <option value="2">Dr. Luis Méndez</option>
              </select>
              <div class="invalid-feedback">Seleccione un médico.</div>
            </div>
          </div>
        </div>

        <div class="row g-4 mb-3">
          <div class="col-md-6">
            <label for="fecha" class="form-label">Fecha</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
              <div class="invalid-feedback">Ingrese la fecha de la receta.</div>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="medicamento" class="form-label">Medicamento</label>
          <input type="text" class="form-control" id="medicamento" name="medicamento" placeholder="Ej: Amoxicilina" required>
          <div class="invalid-feedback">Ingrese el nombre del medicamento.</div>
        </div>

        <div class="row g-4 mb-3">
          <div class="col-md-6">
            <label for="dosis" class="form-label">Dosis</label>
            <input type="text" class="form-control" id="dosis" name="dosis" placeholder="Ej: 500mg cada 8h" required>
            <div class="invalid-feedback">Ingrese la dosis recomendada.</div>
          </div>
          <div class="col-md-6">
            <label for="duracion" class="form-label">Duración</label>
            <input type="text" class="form-control" id="duracion" name="duracion" placeholder="Ej: 7 días" required>
            <div class="invalid-feedback">Ingrese la duración del tratamiento.</div>
          </div>
        </div>

        <div class="mb-4">
          <label for="indicaciones" class="form-label">Indicaciones</label>
          <textarea class="form-control" id="indicaciones" name="indicaciones" rows="3" placeholder="Instrucciones adicionales..." required></textarea>
          <div class="invalid-feedback">Ingrese las indicaciones del tratamiento.</div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Guardar Receta
          </button>
          <a href="listar_recetas.php" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
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
