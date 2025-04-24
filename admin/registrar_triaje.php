<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Formulario Registrar Triaje -->
<div class="container mt-4">
  <div class="card p-4">
    <h4 class="mb-3"><i class="bi bi-heart-pulse-fill me-2"></i> Registrar Triaje</h4>
    <form action="#" method="POST">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="id_paciente" class="form-label">Paciente</label>
          <select class="form-select" id="id_paciente" name="id_paciente" required>
            <option selected disabled>Seleccione un paciente</option>
            <option value="1">Juan Pérez</option>
            <option value="2">Ana Gómez</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="id_usuario" class="form-label">Usuario</label>
          <select class="form-select" id="id_usuario" name="id_usuario" required>
            <option selected disabled>Seleccione un usuario</option>
            <option value="1">Enfermera 1</option>
            <option value="2">Doctor A</option>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="col-md-6">
          <label for="hora" class="form-label">Hora</label>
          <input type="time" class="form-control" id="hora" name="hora" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-3">
          <label for="pulso" class="form-label">Pulso</label>
          <input type="number" class="form-control" id="pulso" name="pulso" required>
        </div>
        <div class="col-md-3">
          <label for="temperatura" class="form-label">Temperatura (°C)</label>
          <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" required>
        </div>
        <div class="col-md-3">
          <label for="peso" class="form-label">Peso (kg)</label>
          <input type="number" step="0.01" class="form-control" id="peso" name="peso" required>
        </div>
        <div class="col-md-3">
          <label for="presion_arterial" class="form-label">Presión Arterial</label>
          <input type="text" class="form-control" id="presion_arterial" name="presion_arterial" required>
        </div>
      </div>

      <button type="submit" class="btn btn-success">
        <i class="bi bi-save me-1"></i> Guardar Triaje
      </button>
    </form>
  </div>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
