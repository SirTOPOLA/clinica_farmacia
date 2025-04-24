<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-capsule-pill me-2"></i> Registrar Tratamiento</h5>
      <a href="listar_tratamiento.php" class="btn btn-light btn-sm">
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
              <select id="paciente" name="paciente" class="form-select" required>
                <option value="">Seleccione un paciente</option>
                <option value="1">Juan Pérez</option>
                <option value="2">María López</option>
              </select>
              <div class="invalid-feedback">Seleccione un paciente.</div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="empleado" class="form-label">Médico Responsable</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
              <select id="empleado" name="empleado" class="form-select" required>
                <option value="">Seleccione un médico</option>
                <option value="1">Dra. Ana Ruiz</option>
                <option value="2">Dr. Luis Méndez</option>
              </select>
              <div class="invalid-feedback">Seleccione un médico.</div>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
          <div class="invalid-feedback">Ingrese la descripción del tratamiento.</div>
        </div>

        <div class="row g-4 mb-3">
          <div class="col-md-6">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
              <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
              <div class="invalid-feedback">Ingrese la fecha de inicio.</div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
              <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
              <div class="invalid-feedback">Ingrese la fecha de fin.</div>
            </div>
          </div>
        </div>

        <div class="mb-4">
          <label for="observaciones" class="form-label">Observaciones</label>
          <textarea id="observaciones" name="observaciones" class="form-control" rows="2"></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i> Guardar
          </button>
          <a href="listar_tratamiento.php" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
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
