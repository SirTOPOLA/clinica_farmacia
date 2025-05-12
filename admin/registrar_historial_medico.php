<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-journal-medical me-2"></i> Registrar Historial Médico</h5>
    </div>

    <div class="card-body">
      <form class="needs-validation" novalidate>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="paciente" class="form-label">Paciente</label>
            <select class="form-select" id="paciente" required>
              <option selected disabled value="">Seleccione un paciente</option>
              <option value="1">Juan Pérez</option>
              <option value="2">María García</option>
            </select>
            <div class="invalid-feedback">Seleccione un paciente válido.</div>
          </div>
          <div class="col-md-6">
            <label for="empleado" class="form-label">Empleado Responsable</label>
            <select class="form-select" id="empleado" required>
              <option selected disabled value="">Seleccione un empleado</option>
              <option value="1">Dra. Ana Ruiz</option>
              <option value="2">Dr. Luis Méndez</option>
            </select>
            <div class="invalid-feedback">Seleccione un empleado responsable.</div>
          </div>
        </div>

        <div class="mb-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha" required>
          <div class="invalid-feedback">Debe indicar la fecha del historial.</div>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea class="form-control" id="descripcion" rows="3" placeholder="Descripción de la visita..." required></textarea>
          <div class="invalid-feedback">Ingrese una descripción de la visita.</div>
        </div>

        <div class="mb-3">
          <label for="diagnostico" class="form-label">Diagnóstico</label>
          <textarea class="form-control" id="diagnostico" rows="2" placeholder="Diagnóstico del paciente..." required></textarea>
          <div class="invalid-feedback">Ingrese el diagnóstico correspondiente.</div>
        </div>

        <div class="mb-3">
          <label for="tratamiento" class="form-label">Tratamiento Recomendado</label>
          <textarea class="form-control" id="tratamiento" rows="2" placeholder="Tratamiento sugerido..." required></textarea>
          <div class="invalid-feedback">Especifique el tratamiento recomendado.</div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-save me-1"></i> Guardar Historial
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
