<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center rounded-top-4">
          <h5 class="mb-0"><i class="bi bi-heart-pulse-fill me-2"></i> Registrar Triaje</h5>
          <a href="javascript:history.back()" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver
          </a>
        </div>

        <div class="card-body">
          <!-- Buscador de pacientes -->
          <div class="mb-4">
            <label for="filtroInput" class="form-label"><i class="bi bi-search me-2"></i>Buscar Paciente</label>
            <input type="text" class="form-control" id="filtroInput" placeholder="Buscar por nombre o código">
          </div>

          <!-- Resultados con radio buttons -->
          <div class="mt-3">
            <ul id="listaResultados" class="list-group"></ul>
          </div>

          <!-- Formulario principal -->
          <form action="../php/insertar_triaje.php" method="POST" class="needs-validation mt-4" novalidate>
            <input type="hidden" id="id_paciente" name="id_paciente">
            <div class="mb-3">
              <label for="nombre_paciente" class="form-label">Paciente</label>
              <input type="text" class="form-control" id="nombre_paciente" placeholder="Seleccione un paciente..." readonly required>
              <div class="invalid-feedback">Seleccione un paciente.</div>
            </div>

            <div class="row g-4">
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

              <!-- Campo de precio -->
              <div class="col-6 col-md-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" min="500" name="precio" required>
                <div class="invalid-feedback">Ingrese el precio.</div>
              </div>
            </div>

            <!-- Nuevo campo de texto para el motivo de la consulta -->
            <div class="mb-3">
              <label for="motivo_consulta" class="form-label">Motivo de la Consulta</label>
              <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" rows="4" required></textarea>
              <div class="invalid-feedback">Ingrese el motivo de la consulta.</div>
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
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>

<!-- Validaciones y búsqueda -->
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
const listaResultados = document.getElementById('listaResultados');
const inputIdPaciente = document.getElementById('id_paciente');
const inputNombrePaciente = document.getElementById('nombre_paciente');

filtroInput.addEventListener('input', function () {
  const query = this.value.trim();
  if (query.length === 0) {
    listaResultados.innerHTML = '';
    return;
  }

  fetch(`../php/buscar_paciente2.php?q=${encodeURIComponent(query)}`)
    .then(response => response.json())
    .then(data => {
      listaResultados.innerHTML = '';

      if (data.length === 0) {
        listaResultados.innerHTML = '<li class="list-group-item">No se encontraron resultados</li>';
        return;
      }

      data.forEach(p => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex align-items-center';

        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = 'seleccion_paciente';
        radio.value = p.id_paciente;
        radio.classList.add('form-check-input', 'me-2');

        radio.addEventListener('change', () => {
          inputIdPaciente.value = p.id_paciente;
          inputNombrePaciente.value = p.display;
          listaResultados.innerHTML = '';
        });

        li.appendChild(radio);
        li.appendChild(document.createTextNode(p.display));
        listaResultados.appendChild(li);
      });
    })
    .catch(error => {
      console.error('Error al buscar pacientes:', error);
    });
});
</script>

</body>
</html>

