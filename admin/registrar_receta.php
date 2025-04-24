<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Container: Registrar Receta Médica -->
<div class="card p-4" id="registrarReceta">
  <h4 class="mb-4">Registrar Nueva Receta</h4>
  <form>
    <div class="mb-3">
      <label for="paciente" class="form-label">Paciente</label>
      <select class="form-select" id="paciente">
        <option selected disabled>Seleccione un paciente</option>
        <option value="1">Juan Pérez</option>
        <option value="2">María García</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="medico" class="form-label">Médico</label>
      <select class="form-select" id="medico">
        <option selected disabled>Seleccione un médico</option>
        <option value="1">Dra. Ana Ruiz</option>
        <option value="2">Dr. Luis Méndez</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" class="form-control" id="fecha">
    </div>

    <div class="mb-3">
      <label for="medicamento" class="form-label">Medicamento</label>
      <input type="text" class="form-control" id="medicamento" placeholder="Ej: Amoxicilina">
    </div>

    <div class="mb-3">
      <label for="dosis" class="form-label">Dosis</label>
      <input type="text" class="form-control" id="dosis" placeholder="Ej: 500mg cada 8h">
    </div>

    <div class="mb-3">
      <label for="duracion" class="form-label">Duración</label>
      <input type="text" class="form-control" id="duracion" placeholder="Ej: 7 días">
    </div>

    <div class="mb-3">
      <label for="indicaciones" class="form-label">Indicaciones</label>
      <textarea class="form-control" id="indicaciones" rows="3" placeholder="Instrucciones adicionales..."></textarea>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-check-circle me-1"></i> Guardar Receta
      </button>
    </div>
  </form>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
