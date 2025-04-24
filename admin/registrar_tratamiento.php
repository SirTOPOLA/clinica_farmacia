<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
  <div class="container mt-4">
  <div class="card p-4">
    <h4 class="mb-3">Registrar Tratamiento</h4>
    <form action="#" method="POST">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="paciente" class="form-label">Paciente</label>
          <select id="paciente" name="paciente" class="form-select" required>
            <option value="">Seleccione un paciente</option>
            <option value="1">Juan Pérez</option>
            <option value="2">María López</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="empleado" class="form-label">Médico Responsable</label>
          <select id="empleado" name="empleado" class="form-select" required>
            <option value="">Seleccione un médico</option>
            <option value="1">Dra. Ana Ruiz</option>
            <option value="2">Dr. Luis Méndez</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
          <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="fecha_fin" class="form-label">Fecha de Fin</label>
          <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea id="observaciones" name="observaciones" class="form-control" rows="2"></textarea>
      </div>
      <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i> Guardar</button>
      <a href="listar_tratamiento.php" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
  </div>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
