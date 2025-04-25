<?php 
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
include_once("../config/conexion.php"); // Asegúrate de tener esta conexión activa
?>

<!-- Main Content -->
<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-calendar-plus me-2"></i> Registrar Nueva Cita</h5>
    </div>

    <div class="card-body">
      <form action="guardar_cita.php" method="POST" class="needs-validation" novalidate>

        <!-- Paciente -->
        <div class="mb-3">
          <label for="paciente" class="form-label">Paciente</label>
          <select class="form-select" id="paciente" name="id_paciente" required>
            <option selected disabled value="">Seleccione un paciente</option>
            <?php
            $pacientes = mysqli_query($conn, "SELECT id_paciente, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM pacientes ORDER BY nombre");
            while ($p = mysqli_fetch_assoc($pacientes)) {
              echo "<option value='{$p['id_paciente']}'>{$p['nombre_completo']}</option>";
            }
            ?>
          </select>
          <div class="invalid-feedback">Seleccione un paciente.</div>
        </div>

        <!-- Empleado -->
        <div class="mb-3">
          <label for="empleado" class="form-label">Empleado (Doctor)</label>
          <select class="form-select" id="empleado" name="id_empleado" required>
            <option selected disabled value="">Seleccione un médico</option>
            <?php
            $empleados = mysqli_query($conn, "SELECT id_empleado, nombre FROM empleados WHERE rol = 'doctor' ORDER BY nombre");
            while ($e = mysqli_fetch_assoc($empleados)) {
              echo "<option value='{$e['id_empleado']}'>{$e['nombre']}</option>";
            }
            ?>
          </select>
          <div class="invalid-feedback">Seleccione un médico responsable.</div>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
          <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
          <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
          <div class="invalid-feedback">Ingrese una fecha válida.</div>
        </div>

        <!-- Hora -->
        <div class="mb-3">
          <label for="hora_cita" class="form-label">Hora de la Cita</label>
          <input type="time" class="form-control" id="hora_cita" name="hora_cita" required>
          <div class="invalid-feedback">Ingrese una hora válida.</div>
        </div>

        <!-- Estado -->
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

        <!-- Botones -->
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
