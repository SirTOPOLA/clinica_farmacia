<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     
  <div class="card p-4">
  <h4 class="mb-4">Registrar Resultado de Laboratorio</h4>
  <form>
    <div class="mb-3">
      <label for="paciente" class="form-label">Paciente</label>
      <select class="form-select" id="paciente" required>
        <option selected disabled>Seleccione un paciente</option>
        <option value="1">Juan Pérez</option>
        <option value="2">María Gómez</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" class="form-control" id="fecha" required>
    </div>
    <div class="mb-3">
      <label for="tipo_estudio" class="form-label">Tipo de Estudio</label>
      <input type="text" class="form-control" id="tipo_estudio" required>
    </div>
    <div class="mb-3">
      <label for="resultado" class="form-label">Resultado</label>
      <textarea class="form-control" id="resultado" rows="2" required></textarea>
    </div>
    <div class="mb-3">
      <label for="observaciones" class="form-label">Observaciones</label>
      <textarea class="form-control" id="observaciones" rows="2"></textarea>
    </div>
    <button type="submit" class="btn btn-success">
      <i class="bi bi-save me-1"></i> Guardar
    </button>
  </form>
</div>

</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
