<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");





try {
  $sql = "
        SELECT c.id_cita,c.recordatorio_enviado, p.nombre AS nombre_paciente, p.apellido AS apellido_paciente,
               e.nombre AS nombre_medico, e.apellido AS apellido_medico,
               c.fecha_cita, c.hora_cita, c.estado
        FROM citas c
        INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
        INNER JOIN empleados e ON c.id_empleado = e.id_empleado
        ORDER BY c.fecha_cita DESC, c.hora_cita DESC
    ";
  $stmt = $conexion->query($sql);
  $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $_SESSION['error'] = "Error al cargar citas: " . $e->getMessage();
  $citas = [];
}

?>

<!-- Main Content -->
<div class="main-content">
  <div class="conten-wrapper">
    <div class="card shadow-lg mt-4 border-0">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top">
        <h2 class="mb-0"><span class="material-icons">event_note</span> Gestión de Citas</h2>
        <button class="btn btn-primary text-white shadow-sm rounded-3" onclick="window.location='registrar_cita.php'">
          <span class="material-icons">add </span>
        </button>
      </div>

      <!-- para las alertas -->
      <div id="alert-container" class="mb-3">
        <?php include_once("../includes/sidebar.php"); ?>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por paciente, empleado o estado..."
                oninput="buscarCitas()">
            </div>
          </div>
        </div>

        <div id="tabla-citas" class="table-responsive">
          <table class="table table-striped table-hover shadow-sm rounded">
            <thead class="bg-secondary text-white">
              <tr>
                <th><span class="material-icons">person</span> Paciente</th>
                <th><span class="material-icons">medical_services</span> Empleado</th>
                <th><span class="material-icons">event</span> Fecha</th>
                <th><span class="material-icons">access_time</span> Hora</th>
                <th><span class="material-icons">check_circle</span> Estado</th>
                <th><span class="material-icons">mark_email_read</span> Recordatorio</th>
                <th><span class="material-icons">settings</span> Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($citas)): ?>
                <?php foreach ($citas as $cita): ?>
                  <tr>
                    <td><?= htmlspecialchars($cita['nombre_paciente'] . ' ' . $cita['apellido_paciente']) ?></td>
                    <td><?= htmlspecialchars($cita['nombre_medico'] . ' ' . $cita['apellido_medico']) ?></td>
                    <td><?= htmlspecialchars($cita['fecha_cita']) ?></td>
                    <td><?= htmlspecialchars($cita['hora_cita']) ?></td>
                    <td>
                      <span class="badge bg-<?= match ($cita['estado']) {
                                              'pendiente' => 'warning',
                                              'confirmada' => 'primary',
                                              'completada' => 'success',
                                              'cancelada' => 'danger',
                                              default => 'secondary'
                                            } ?>">
                        <?= ucfirst($cita['estado']) ?>
                      </span>
                    </td>
                    <td>
                      <?= $cita['recordatorio_enviado'] ? '<span class="text-success">✅ Enviado</span>' : '<span class="text-muted">⏳ No</span>' ?>
                    </td>
                    <td>
                      <a href="editar_cita.php?id=<?= $cita['id_cita'] ?>" class="btn btn-sm btn-primary">Editar</a>
                      <a href="eliminar_cita.php?id=<?= $cita['id_cita'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta cita?')">Eliminar</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">No se encontraron citas registradas.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>


</body>

</html>