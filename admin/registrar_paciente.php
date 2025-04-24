<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Registro de Paciente -->
<div id="registroPaciente" class="card p-4 mt-4">
  <h4 class="mb-3"><i class="bi bi-person-plus me-2"></i>Registrar Paciente</h4>
  <form action="../php/insertar_pacientes.php" method="POST">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" class="form-control" name="codigo" >
      </div>
      <div class="col-md-4 mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" name="apellido" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" name="fecha_nacimiento" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="genero" class="form-label">Género</label>
        <select class="form-select" name="genero" required>
          <option value="">Seleccione</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
          <option value="Otro">Otro</option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" class="form-control" name="telefono">
      </div>
      <div class="col-md-6 mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" name="direccion">
      </div>
      <div class="col-md-6 mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" name="correo">
      </div>
    </div>
    <button type="submit" class="btn btn-success">
      <i class="bi bi-save me-1"></i> Guardar Paciente
    </button>
  </form>
</div>

 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
