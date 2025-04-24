<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-heart-pulse-fill me-2"></i> Registrar Triaje</h5>
      <a href="javascript:history.back()" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left-circle me-1"></i> Volver
      </a>
    </div>

    <div class="card-body">
      <div class="mb-4">
        <label for="filtroInput" class="form-label"><i class="bi bi-search me-2"></i>Buscar Paciente</label>
        <input type="text" class="form-control" id="filtroInput" placeholder="Buscar por nombre o código">
      </div>

      <form action="#" method="POST" class="needs-validation" novalidate>
        <div class="row g-4">
          <div class="col-md-6">
            <label for="id_paciente" class="form-label">Paciente</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <select class="form-select" id="id_paciente" name="id_paciente" required>
                <option selected disabled>Seleccione un paciente</option>
              </select>
              <div class="invalid-feedback">Seleccione un paciente.</div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="id_usuario" class="form-label">Usuario</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
              <select class="form-select" id="id_usuario" name="id_usuario" required>
                <option selected disabled value="">Seleccione un usuario</option>
                <option value="1">Enfermera 1</option>
                <option value="2">Doctor A</option>
              </select>
              <div class="invalid-feedback">Seleccione un usuario.</div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="fecha" class="form-label">Fecha</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
              <div class="invalid-feedback">Ingrese la fecha.</div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="hora" class="form-label">Hora</label>
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-clock"></i></span>
              <input type="time" class="form-control" id="hora" name="hora" required>
              <div class="invalid-feedback">Ingrese la hora.</div>
            </div>
          </div>

          <div class="col-6 col-md-3">
            <label for="pulso" class="form-label">Pulso</label>
            <input type="number" class="form-control" id="pulso" name="pulso" required>
            <div class="invalid-feedback">Ingrese el pulso.</div>
          </div>

          <div class="col-6 col-md-3">
            <label for="temperatura" class="form-label">Temperatura (°C)</label>
            <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" required>
            <div class="invalid-feedback">Ingrese la temperatura.</div>
          </div>

          <div class="col-6 col-md-3">
            <label for="peso" class="form-label">Peso (kg)</label>
            <input type="number" step="0.01" class="form-control" id="peso" name="peso" required>
            <div class="invalid-feedback">Ingrese el peso.</div>
          </div>

          <div class="col-6 col-md-3">
            <label for="presion_arterial" class="form-label">Presión Arterial</label>
            <input type="text" class="form-control" id="presion_arterial" name="presion_arterial" required>
            <div class="invalid-feedback">Ingrese la presión arterial.</div>
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Guardar Triaje
          </button>
          <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
          </a>
        </div>
      </form>

      <!-- Resultados del buscador -->
      <div class="mt-5">
        <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i>Resultados</h5>
        <ul id="listaResultados" class="list-group"></ul>
      </div>
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

const filtroInput = document.getElementById('filtroInput');
const pacienteSelect = document.getElementById('id_paciente');
const listaResultados = document.getElementById('listaResultados');

filtroInput.addEventListener('input', function () {
  const query = this.value.trim();
  if (query.length === 0) {
    listaResultados.innerHTML = '';
    return;
  }

  fetch(`../php/buscar_paciente.php?q=${encodeURIComponent(query)}`)
    .then(response => response.json())
    .then(data => {
      pacienteSelect.innerHTML = '<option disabled selected>Seleccione un paciente</option>';
      listaResultados.innerHTML = '';

      data.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id_paciente;
        opt.textContent = p.display;
        pacienteSelect.appendChild(opt);

        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.textContent = p.display;
        listaResultados.appendChild(li);
      });
    })
    .catch(error => console.error('Error al buscar pacientes:', error));
});
</script>
