<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
     <!-- Sección Registro de Usuario -->
<div id="registroUsuario" class="card p-4 mt-4">
  <h4 class="mb-3"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Usuario</h4>
  
  <form action="../php/insertar_usuarios.php" method="POST">
    <!-- Código de Empleado -->
    <div class="mb-3">
      <label for="codigo_empleado" class="form-label">Código de Empleado</label>
      <input type="text" class="form-control" id="codigo_empleado" name="codigo_empleado" required>
    </div>

    <!-- Correo -->
    <div class="mb-3">
      <label for="correo" class="form-label">Correo Electrónico</label>
      <input type="email" class="form-control" id="correo" name="correo" required>
    </div>

    <!-- Contraseña -->
    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="contrasena" name="contrasena" required>
    </div>

    <!-- Rol -->
    <div class="mb-3">
      <label for="id_rol" class="form-label">Rol</label>
      <select class="form-select" id="id_rol" name="id_rol" required>
        <option value="" selected disabled>Seleccione un rol</option>
        <option value="1">RECEPCION</option>
        <option value="2">ADMINISTRADOR</option>
        <option value="3">ENFERMERIA</option>
        <option value="4">LABORATORIO</option>
        <option value="5">MEDICO</option>
      </select>
    </div>

    <!-- Activo -->
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
      <label class="form-check-label" for="activo">
        Usuario Activo
      </label>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Guardar Usuario
      </button>
    </div>
  </form>
</div>

 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
