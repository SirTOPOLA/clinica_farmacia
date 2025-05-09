<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");



// Obtener el ID del usuario logueado desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Consultar el rol del usuario logueado
$query = "
  SELECT r.nombre_rol 
  FROM usuarios u
  JOIN roles r ON u.id_rol = r.id_rol
  WHERE u.id_usuario = :id_usuario
";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$rol_usuario = $stmt->fetchColumn(); // El rol del usuario (Ej: ENFERMERIA o ADMINISTRADOR)

// Consultar los registros de triaje con los datos de paciente y usuario
$query_triaje = "
 SELECT 
  t.id_triaje, 
  t.id_paciente, 
  p.nombre AS paciente, 
  t.fecha, 
  t.hora, 
  t.pulso, 
  t.temperatura, 
  t.peso, 
  t.presion_arterial, 
  t.precio, 
  u.correo AS usuario
FROM triaje t
JOIN pacientes p ON t.id_paciente = p.id_paciente
JOIN usuarios u ON t.id_usuario = u.id_usuario
ORDER BY t.fecha DESC, t.hora DESC
";
$stmt_triaje = $conexion->prepare($query_triaje);
$stmt_triaje->execute();
$registros_triaje = $stmt_triaje->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">monitor_heart</span> Registros de Triaje</h2>

        <!-- Mostrar el botón de añadir nuevo solo si el rol es ENFERMERIA -->
        <?php if ($rol_usuario == 'ENFERMERIA'): ?>
          <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_triaje.php'">
            <span class="material-icons">add</span> Añadir Nuevo
          </button>
        <?php endif; ?>
      </div>

      <!-- para las alertas -->
      <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded"
                placeholder="🔍 Buscar por nombre de paciente o fecha..." oninput="buscarTriaje()">
            </div>
          </div>
        </div>

        <div id="tabla-triaje" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-dark text-white">
              <tr>
                <th><span class="material-icons">person</span> Paciente</th>
                <th><span class="material-icons">event</span> Fecha</th>
                <th><span class="material-icons">schedule</span> Hora</th>
                <th><span class="material-icons">favorite</span> Pulso</th>
                <th><span class="material-icons">thermostat</span> Temp (°C)</th>
                <th><span class="material-icons">monitor_weight</span> Peso (kg)</th>
                <th><span class="material-icons">bloodtype</span> Presión</th>
                <th><span class="material-icons">attach_money</span> Precio</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($registros_triaje as $triaje): ?>
                <tr>
                  <td><?= htmlspecialchars($triaje['paciente']) ?></td>
                  <td><?= htmlspecialchars($triaje['fecha']) ?></td>
                  <td><?= htmlspecialchars($triaje['hora']) ?></td>
                  <td><?= htmlspecialchars($triaje['pulso']) ?></td>
                  <td><?= htmlspecialchars($triaje['temperatura']) ?></td>
                  <td><?= htmlspecialchars($triaje['peso']) ?></td>
                  <td><?= htmlspecialchars($triaje['presion_arterial']) ?></td>
                  <td class="precio-verde"><?= htmlspecialchars($triaje['precio']) ?></td>

                  <td>
                    <!-- Mostrar solo el botón de Editar para ENFERMERIA -->
                    <?php if ($rol_usuario == 'ENFERMERIA'): ?>
                      <a href="editar_triaje.php?id=<?= $triaje['id_triaje'] ?>" class="btn btn-warning btn-sm">
                        <span class="material-icons">edit</span> Editar
                      </a>
                    <?php endif; ?>

                    <!-- Mostrar solo los botones de Eliminar y Pruebas Médicas para ADMINISTRADOR -->
                    <?php if ($rol_usuario == 'ADMINISTRADOR'): ?>
                      <a href="eliminar_triaje.php?id=<?= $triaje['id_triaje'] ?>" class="btn btn-danger btn-sm">
                        <span class="material-icons">delete</span> Eliminar
                      </a>
                     
                    <?php endif; ?>

                    <?php if ($rol_usuario == 'ADMINISTRADOR' || $rol_usuario == 'MEDICO'): ?>

                      <a href="asig_pruebas.php?id_paciente=<?= $triaje['id_paciente'] ?>&id_triaje=<?= $triaje['id_triaje'] ?>" class="btn btn-success btn-sm">
                        <span class="material-icons">science</span> Pruebas Médicas
                      </a>

                      <button class="btn btn-info btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalReceta"
                        data-id-paciente="<?= $triaje['id_paciente'] ?>"
                        data-nombre-paciente="<?= htmlspecialchars($triaje['paciente']) ?>">
                        <span class="material-icons">receipt_long</span> Receta
                      </button>
                    <?php endif; ?>



                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalReceta" tabindex="-1" aria-labelledby="modalRecetaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header bg-info text-white rounded-top">
        <h5 class="modal-title" id="modalRecetaLabel"><span class="material-icons">medication</span> Crear Receta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form action="../php/insertar_receta.php" method="POST">
        <div class="modal-body bg-light">
          <input type="hidden" name="id_paciente" id="modal-id-paciente">
          <input type="hidden" name="id_empleado" id="modal-id-empleado">

          <div class="mb-3">
            <label class="form-label fw-bold">Nombre del Paciente:</label>
            <input type="text" id="modal-nombre-paciente" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Fecha:</label>
            <input type="text" class="form-control" name="fecha" value="<?= date('Y-m-d') ?>" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Medicamento:</label>
            <textarea class="form-control" name="medicamento" rows="2" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Instrucciones:</label>
            <textarea class="form-control" name="instrucciones" rows="3" required>M                T                 N</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Duración (días):</label>
            <input type="number" min="1" class="form-control" name="duracion" required>
          </div>
        </div>
        <div class="modal-footer bg-light rounded-bottom">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info text-white">Guardar Receta</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
  // Lógica de temporizador para eliminar las alertas después de 10 segundos
  setTimeout(() => {
    const alerta = document.getElementById('alerta');
    if (alerta) {
      alerta.classList.add('fade');
      alerta.style.transition = 'opacity 0.5s';
      alerta.style.opacity = '0';
      setTimeout(() => alerta.remove(), 500);
    }
  }, 10000); // 10 segundos
</script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modalReceta = document.getElementById('modalReceta');
    modalReceta.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const idPaciente = button.getAttribute('data-id-paciente');
      const nombrePaciente = button.getAttribute('data-nombre-paciente');

      document.getElementById('modal-id-paciente').value = idPaciente;
      document.getElementById('modal-nombre-paciente').value = nombrePaciente;

      fetch('obtener_empleado.php')
        .then(response => response.json())
        .then(data => {
          document.getElementById('modal-id-empleado').value = data.id_empleado;
        });
    });
  });
</script>


<!-- Bootstrap 5.3 JS y Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>

</html>