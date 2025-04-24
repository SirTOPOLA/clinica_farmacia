<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
  <div class="card p-4">
  <h4 class="mb-4">Registrar Notificación</h4>
  <form>
    <div class="mb-3">
      <label for="mensaje" class="form-label">Mensaje</label>
      <textarea class="form-control" id="mensaje" rows="3" placeholder="Escriba el mensaje..."></textarea>
    </div>
    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo</label>
      <select class="form-select" id="tipo">
        <option value="" disabled selected>Seleccione tipo</option>
        <option value="caducidad_medicamento">Caducidad de Medicamento</option>
        <option value="recordatorio_cita">Recordatorio de Cita</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">
      <i class="bi bi-bell-fill me-1"></i> Registrar Notificación
    </button>
  </form>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
