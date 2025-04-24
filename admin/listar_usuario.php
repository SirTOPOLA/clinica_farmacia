<?php
include_once("../includes/header.php");



include '../config/conexion.php';


// Consulta con JOIN para traer nombre del empleado y rol
$stmt = $conexion->query("
    SELECT u.id_usuario, u.codigo_empleado, u.correo, u.activo,
           e.nombre AS nombre_empleado, e.apellido AS apellido_empleado,
           r.nombre_rol
    FROM usuarios u
    JOIN empleados e ON u.codigo_empleado = e.codigo_empleado
    JOIN roles r ON u.id_rol = r.id_rol
    ORDER BY u.id_usuario DESC
");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!-- Main Content -->
<div class="main-content">
  <div id="usuarios" class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Lista de Usuarios</h4>
      <a class="btn btn-primary" href="registrar_usuario.php">
        <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
      </a>
    </div>
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Codigo-Empleado</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['id_usuario']) ?></td>
            <td><?= htmlspecialchars($u['codigo_empleado']) ?></td>
            <td><?= htmlspecialchars($u['nombre_empleado'] . ' ' . $u['apellido_empleado']) ?></td>
            <td><?= htmlspecialchars($u['correo']) ?></td>
            <td><?= htmlspecialchars($u['nombre_rol']) ?></td>
            <td>
              <span class="badge <?= $u['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                <?= $u['activo'] ? 'Activo' : 'Inactivo' ?>
              </span>
            </td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="editarUsuario(<?= $u['id_usuario'] ?>)">
                <i class="bi bi-pencil"></i>
              </button>

              <?php if ($u['activo']): ?>
                <!-- Botón de desactivar -->
                <button class="btn btn-sm btn-secondary" onclick="confirmarDesactivar(<?= $u['id_usuario'] ?>)">
                  <i class="bi bi-person-dash"></i> Desactivar
                </button>
              <?php else: ?>
                <!-- Botón de activar -->
                <button class="btn btn-sm btn-success" onclick="confirmarActivar(<?= $u['id_usuario'] ?>)">
                  <i class="bi bi-person-check"></i> Activar
                </button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>


      </tbody>
    </table>
  </div>








  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Función para confirmar la desactivación de un usuario
  function confirmarDesactivar(idUsuario) {
    // Confirmación de desactivación
    var confirmacion = confirm("¿Estás seguro de que deseas desactivar este usuario?");
    
    if (confirmacion) {
      // Enviar el formulario para desactivar al usuario
      window.location.href = '../php/desactivar_usuario.php?id_usuario=' + idUsuario;
    }
  }

  // Función para confirmar la activación de un usuario
  function confirmarActivar(idUsuario) {
    // Confirmación de activación
    var confirmacion = confirm("¿Estás seguro de que deseas activar este usuario?");
    
    if (confirmacion) {
      // Enviar el formulario para activar al usuario
      window.location.href = '../php/activar_usuario.php?id_usuario=' + idUsuario;
    }
  }
</script>


  </body>

  </html>