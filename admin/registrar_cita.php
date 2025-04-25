<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-calendar-plus me-2"></i> Registrar Nueva Cita</h5>
    </div>

    <div class="card-body">
      <form action="guardar_cita.php" method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="paciente" class="form-label">Paciente</label>
          <select class="form-select" id="paciente" name="id_paciente" required>
            <option selected disabled value="">Seleccione un paciente</option>
            <option value="1">Juan Pérez</option>
            <option value="2">María García</option>
          </select>
          <div class="invalid-feedback">Seleccione un paciente.</div>
        </div>

        <div class="mb-3">
          <label for="empleado" class="form-label">Empleado (Doctor)</label>
          <select class="form-select" id="empleado" name="id_empleado" required>
            <option selected disabled value="">Seleccione un médico</option>
            <option value="1">Dra. Ana López</option>
            <option value="2">Dr. Carlos Ruiz</option>
          </select>
          <div class="invalid-feedback">Seleccione un médico responsable.</div>
        </div>

        <div class="mb-3">
          <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
          <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
          <div class="invalid-feedback">Ingrese una fecha válida.</div>
        </div>

        <div class="mb-3">
          <label for="hora_cita" class="form-label">Hora de la Cita</label>
          <input type="time" class="form-control" id="hora_cita" name="hora_cita" required>
          <div class="invalid-feedback">Ingrese una hora válida.</div>
        </div>

        <div class="mb-3">
          <label for="estado" class="form-label">Estado</label>
          <select class="form-select" id="estado" name="estado" required>
            <option value="pendiente" selected>Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="cancelada">Cancelada</option>
            <option value="completada">Completada</option>
          </select>
          <div class="invalid-feedback">Seleccione el estado de la cita.</div>
        </div>

        <div class="d-flex justify-content-between">
          <a href="listar_cita.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
          </a>
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-save me-1"></i> Guardar Cita
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Script para búsqueda de pacientes -->
<!-- Script para búsqueda de pacientes -->
<script>
  document.getElementById('filtroPaciente').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const pacientes = <?php echo json_encode($pacientes); ?>;
    const filteredPacientes = pacientes.filter(paciente => 
      paciente.codigo.toLowerCase().includes(filtro) || 
      paciente.nombre.toLowerCase().includes(filtro) || 
      paciente.apellido.toLowerCase().includes(filtro)
    ).slice(0, 5);  // Solo mostrar los primeros 5

    const listaPacientesContainer = document.getElementById('listaPacientesContainer');
    const listaPacientes = document.getElementById('listaPacientes');

    listaPacientes.innerHTML = ''; // Limpiar resultados previos

    // Mostrar u ocultar la lista de pacientes según si hay coincidencias
    if (filtro.trim() === '') {
      listaPacientesContainer.style.display = 'none'; // Ocultar si no hay texto
    } else if (filteredPacientes.length > 0) {
      listaPacientesContainer.style.display = 'block'; // Mostrar la lista
      filteredPacientes.forEach(paciente => {
        const label = document.createElement('label');
        label.classList.add('list-group-item');
        label.style.backgroundColor = '#ADD8E6'; // Azul claro para diferenciar

        label.innerHTML = `
          <input class="form-check-input me-1" type="radio" name="codigo" value="${paciente.codigo}" required>
          ${paciente.codigo} - ${paciente.nombre} ${paciente.apellido}
        `;
        listaPacientes.appendChild(label);
      });
    } else {
      listaPacientesContainer.style.display = 'none'; // Ocultar si no hay coincidencias
    }
  });
</script>

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