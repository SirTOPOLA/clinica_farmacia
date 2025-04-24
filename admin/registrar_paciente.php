<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i> Registrar Paciente</h5>
    </div>

    <div class="card-body">
      <form action="../php/insertar_pacientes.php" method="POST" class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="codigo" class="form-label">Código</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
              <input type="text" class="form-control" name="codigo">
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" name="nombre" required>
              <div class="invalid-feedback">Ingrese el nombre del paciente.</div>
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
              <input type="text" class="form-control" name="apellido" required>
              <div class="invalid-feedback">Ingrese el apellido del paciente.</div>
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="fecha_nacimiento" required>
            <div class="invalid-feedback">Seleccione la fecha de nacimiento.</div>
          </div>

          <div class="col-md-4 mb-3">
            <label for="genero" class="form-label">Género</label>
            <select class="form-select" name="genero" required>
              <option value="">Seleccione</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
              <option value="Otro">Otro</option>
            </select>
            <div class="invalid-feedback">Seleccione el género.</div>
          </div>

          <div class="col-md-4 mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone"></i></span>
              <input type="text" class="form-control" name="telefono">
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
              <input type="text" class="form-control" name="direccion">
            </div>
          </div>

          <div class="col-md-6 mb-4">
            <label for="correo" class="form-label">Correo electrónico</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" class="form-control" name="correo">
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-check-circle me-1"></i> Guardar Paciente
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
