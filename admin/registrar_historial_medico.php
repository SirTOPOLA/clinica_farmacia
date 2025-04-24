<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     
 <!-- Sección: Registrar Historial Médico -->
<div class="card p-4" id="registrarHistorial">
  <h4 class="mb-4">Registrar Historial Médico</h4>
  <form>
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="paciente" class="form-label">Paciente</label>
        <select class="form-select" id="paciente" required>
          <option selected disabled>Seleccione un paciente</option>
          <option value="1">Juan Pérez</option>
          <option value="2">María García</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="empleado" class="form-label">Empleado Responsable</label>
        <select class="form-select" id="empleado" required>
          <option selected disabled>Seleccione un empleado</option>
          <option value="1">Dra. Ana Ruiz</option>
          <option value="2">Dr. Luis Méndez</option>
        </select>
      </div>
    </div>
    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" class="form-control" id="fecha" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea class="form-control" id="descripcion" rows="3" placeholder="Descripción de la visita..." required></textarea>
    </div>
    <div class="mb-3">
      <label for="diagnostico" class="form-label">Diagnóstico</label>
      <textarea class="form-control" id="diagnostico" rows="2" placeholder="Diagnóstico del paciente..." required></textarea>
    </div>
    <div class="mb-3">
      <label for="tratamiento" class="form-label">Tratamiento Recomendado</label>
      <textarea class="form-control" id="tratamiento" rows="2" placeholder="Tratamiento sugerido..." required></textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Guardar Historial
      </button>
    </div>
  </form>
</div>

</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
