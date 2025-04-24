<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
  <div class="container py-5">
  <div class="card p-4">
    <h4 class="mb-4">Registrar Nueva Cita</h4>
    <form action="guardar_cita.php" method="POST">
      <div class="mb-3">
        <label for="paciente" class="form-label">Paciente</label>
        <select class="form-select" id="paciente" name="id_paciente" required>
          <option selected disabled value="">Seleccione un paciente</option>
          <option value="1">Juan Pérez</option>
          <option value="2">María García</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="empleado" class="form-label">Empleado (Doctor)</label>
        <select class="form-select" id="empleado" name="id_empleado" required>
          <option selected disabled value="">Seleccione un médico</option>
          <option value="1">Dra. Ana López</option>
          <option value="2">Dr. Carlos Ruiz</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
        <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
      </div>

      <div class="mb-3">
        <label for="hora_cita" class="form-label">Hora de la Cita</label>
        <input type="time" class="form-control" id="hora_cita" name="hora_cita" required>
      </div>

      <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select class="form-select" id="estado" name="estado" required>
          <option value="pendiente" selected>Pendiente</option>
          <option value="confirmada">Confirmada</option>
          <option value="cancelada">Cancelada</option>
          <option value="completada">Completada</option>
        </select>
      </div>

      <div class="d-flex justify-content-between">
        <a href="listar_cita.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save me-1"></i> Guardar Cita
        </button>
      </div>
    </form>
  </div>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
