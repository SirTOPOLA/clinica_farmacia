<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">history_edu</span> Historial Médico</h2>
      </div>

      <!-- Alertas si las tienes -->
      <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>

      <div class="card-body bg-light">
        <div class="row justify-content-center mb-4">
          <div class="col-md-4 d-grid mb-3">
            <button class="btn btn-outline-primary btn-lg shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalPorFecha">
              <span class="material-icons">calendar_today</span> Imprimir Historial por Fecha
            </button>
          </div>
          <div class="col-md-4 d-grid mb-3">
            <button class="btn btn-outline-success btn-lg shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalGeneral">
              <span class="material-icons">assignment</span> Imprimir Historial General
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Imprimir por Fecha -->
<div class="modal fade" id="modalPorFecha" tabindex="-1" aria-labelledby="modalPorFechaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalPorFechaLabel"><span class="material-icons">calendar_today</span> Historial por Fecha</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="imprimir_historial_fecha.php" method="get" target="_blank">
        <div class="modal-body">
          <div class="mb-3">
            <label for="codigo_paciente_fecha" class="form-label">Código del Paciente</label>
            <input type="text" name="codigo" id="codigo_paciente_fecha" class="form-control shadow-sm" required>
          </div>
          <div class="mb-3">
            <label for="fecha_historial" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha_historial" class="form-control shadow-sm" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary rounded-pill"><span class="material-icons">print</span> Imprimir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Historial General -->
<div class="modal fade" id="modalGeneral" tabindex="-1" aria-labelledby="modalGeneralLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalGeneralLabel"><span class="material-icons">assignment</span> Historial General</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="imprimir_historial_general.php" method="get" target="_blank">
        <div class="modal-body">
          <div class="mb-3">
            <label for="codigo_paciente_general" class="form-label">Código del Paciente</label>
            <input type="text" name="codigo" id="codigo_paciente_general" class="form-control shadow-sm" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill"><span class="material-icons">print</span> Imprimir</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Enlazar Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


<!-- Cierra el HTML -->
</body>
</html>
