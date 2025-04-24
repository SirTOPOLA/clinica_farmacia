<?php
include_once("../includes/header.php");



include '../config/conexion.php';
session_start();

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
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalConfirmarAccion"
                data-id="<?= $u['id_usuario'] ?>"
                data-nombre="<?= $u['nombre_empleado'] ?>"
                data-apellido="<?= $u['apellido_empleado'] ?>"
                data-correo="<?= $u['correo'] ?>"
                data-codigo="<?= $u['codigo_empleado'] ?>"
                data-rol="<?= $u['nombre_rol'] ?>"
                data-accion="<?= $u['activo'] ? 'desactivar' : 'activar' ?>">
                <i class="bi bi-pencil"></i> Editar
              </button>

              <!-- Botón de activar/desactivar con ícono -->
              <button class="btn btn-sm <?= $u['activo'] ? 'btn-danger' : 'btn-success' ?>" data-bs-toggle="modal" data-bs-target="#modalConfirmarAccion"
                data-id="<?= $u['id_usuario'] ?>"
                data-nombre="<?= $u['nombre_empleado'] ?>"
                data-apellido="<?= $u['apellido_empleado'] ?>"
                data-correo="<?= $u['correo'] ?>"
                data-codigo="<?= $u['codigo_empleado'] ?>"
                data-rol="<?= $u['nombre_rol'] ?>"
                data-accion="<?= $u['activo'] ? 'desactivar' : 'activar' ?>">
                <i class="bi <?= $u['activo'] ? 'bi-person-dash' : 'bi-person-check' ?>"></i>
                <?= $u['activo'] ? 'Desactivar' : 'Activar' ?>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>


      </tbody>
    </table>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="modalConfirmarAccion" tabindex="-1" aria-labelledby="modalConfirmarAccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalConfirmarAccionLabel">
            <i class="bi bi-person-circle"></i> Confirmar Acción
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p><strong>¿Estás seguro de que deseas <span id="accion-texto"></span> al siguiente usuario?</strong></p>

          <!-- Datos del usuario -->
          <ul class="list-unstyled">
            <li><strong>Nombre:</strong> <span id="nombre-usuario"></span></li>
            <li><strong>Apellido:</strong> <span id="apellido-usuario"></span></li>
            <li><strong>Correo:</strong> <span id="correo-usuario"></span></li>
            <li><strong>Código de Empleado:</strong> <span id="codigo-empleado"></span></li>
            <li><strong>Rol:</strong> <span id="rol-usuario"></span></li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
          <form id="form-accion" method="POST">
            <input type="hidden" name="id_usuario" id="id-usuario">
            <input type="hidden" name="accion" id="accion">
            <button type="submit" class="btn btn-success" id="confirmar-btn"><i class="bi bi-check-circle"></i> Confirmar</button>
          </form>
        </div>
      </div>
    </div>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // Evento para abrir el modal
  var myModal = document.getElementById('modalConfirmarAccion');
  myModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // El botón que activó el modal

    // Datos del usuario
    var idUsuario = button.getAttribute('data-id');
    var nombreUsuario = button.getAttribute('data-nombre');
    var apellidoUsuario = button.getAttribute('data-apellido');
    var correoUsuario = button.getAttribute('data-correo');
    var codigoEmpleado = button.getAttribute('data-codigo');
    var rolUsuario = button.getAttribute('data-rol');
    var accion = button.getAttribute('data-accion');
    
    // Asignar los valores al modal
    var accionTexto = accion === 'activar' ? 'activar' : 'desactivar';
    document.getElementById('accion-texto').textContent = accionTexto;
    document.getElementById('nombre-usuario').textContent = nombreUsuario;
    document.getElementById('apellido-usuario').textContent = apellidoUsuario;
    document.getElementById('correo-usuario').textContent = correoUsuario;
    document.getElementById('codigo-empleado').textContent = codigoEmpleado;
    document.getElementById('rol-usuario').textContent = rolUsuario;
    document.getElementById('id-usuario').value = idUsuario;
    document.getElementById('accion').value = accion;

    // Cambiar el texto del botón de confirmación dependiendo de la acción
    var confirmarBtn = document.getElementById('confirmar-btn');
    confirmarBtn.textContent = accion === 'activar' ? 'Activar Usuario' : 'Desactivar Usuario';
  });
</script>

  </body>

  </html>