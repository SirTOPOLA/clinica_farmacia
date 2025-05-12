<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">history_edu</span> Historial Médico</h2>
        <div>
          <button class="btn btn-light text-dark me-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalPorFecha">
            <span class="material-icons">event</span> Imprimir por Fecha
          </button>
          <button class="btn btn-success text-white shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalGeneral">
            <span class="material-icons">description</span> Historial General
          </button>
        </div>
      </div>

      <div class="card-body bg-light">
        <div class="alert alert-info text-center rounded-pill shadow-sm">
          Usa los botones de arriba para imprimir el historial médico de un paciente.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para historial por fecha -->
<div class="modal fade" id="modalPorFecha" tabindex="-1" aria-labelledby="modalPorFechaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="modalPorFechaLabel">Imprimir Historial por Fecha</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form action="imprimir_historial_fecha.php" method="GET" target="_blank">
        <div class="modal-body">
          <div class="mb-3">
            <label for="codigoFecha" class="form-label">Código del Paciente</label>
            <input type="text" name="codigo_paciente" id="codigo_paciente" class="form-control shadow-sm rounded" required>
          </div>
          <div class="mb-3">
            <label for="fechaHistorial" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fechaHistorial" class="form-control shadow-sm rounded" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary rounded-pill">Imprimir</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para historial general -->
<div class="modal fade" id="modalGeneral" tabindex="-1" aria-labelledby="modalGeneralLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-success text-white rounded-top">
        <h5 class="modal-title" id="modalGeneralLabel">Imprimir Historial General</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form action="imprimir_historial_general.php" method="GET" target="_blank">
        <div class="modal-body">
          <div class="mb-3">
            <label for="codigoGeneral" class="form-label">Código del Paciente</label>
            <input type="text" name="codigo" id="codigoGeneral" class="form-control shadow-sm rounded" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill">Imprimir</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Enlazar Bootstrap JS y dependencias -->
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>


</body>
</html>

