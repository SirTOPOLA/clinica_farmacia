<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");





try {
  $sql = "
        SELECT c.id_cita, p.nombre AS nombre_paciente, p.apellido AS apellido_paciente,
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
<<<<<<< HEAD
<!-- Main Content -->
<div class="main-content">




  <!-- Notificaciones -->
  <?php if (isset($_SESSION['exito'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $_SESSION['exito'];
      unset($_SESSION['exito']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $_SESSION['error'];
      unset($_SESSION['error']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>




  <!-- Sección de Citas -->
  <div id="citas" class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Listado de Citas</h4>
      <a href="registrar_cita.php" class="btn btn-primary">
        <i class="bi bi-calendar-plus me-1"></i> Registrar Cita
      </a>
    </div>
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Paciente</th>
          <th>Empleado</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>


      <tbody>
        <?php if (count($citas) > 0): ?>
          <?php foreach ($citas as $index => $cita): ?>
            <tr>
              <td><?php echo $index + 1; ?></td>
              <td><?php echo $cita['nombre_paciente'] . ' ' . $cita['apellido_paciente']; ?></td>
              <td><?php echo $cita['nombre_medico'] . ' ' . $cita['apellido_medico']; ?></td>
              <td><?php echo $cita['fecha_cita']; ?></td>
              <td><?php echo date('H:i', strtotime($cita['hora_cita'])); ?></td>
              <td>
                <span class="badge bg-<?php
                                      switch ($cita['estado']) {
                                        case 'pendiente':
                                          echo 'warning';
                                          break;
                                        case 'confirmada':
                                          echo 'primary';
                                          break;
                                        case 'cancelada':
                                          echo 'danger';
                                          break;
                                        case 'completada':
                                          echo 'success';
                                          break;
                                        default:
                                          echo 'secondary';
                                      }
                                      ?>">
                  <?php echo ucfirst($cita['estado']); ?>
                </span>
              </td>
              <td>
                <a href="editar_cita.php?id=<?php echo $cita['id_cita']; ?>" class="btn btn-sm btn-outline-primary">
                  Editar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">No hay citas registradas.</td>
          </tr>
        <?php endif; ?>
      </tbody>


    </table>
  </div>


</div>



<script>
  // Ocultar alertas después de 7 segundos
  setTimeout(() => {
    const alerts = document.querySelectorAll('.alert-auto-dismiss');
    alerts.forEach(alert => {
      alert.classList.remove('show');
      alert.style.opacity = '0';
    });
  }, 7000);
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
=======

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
            <tbody></tbody>
          </table>
        </div>

        <div id="paginacion" class="d-flex justify-content-center"></div>
      </div>
    </div>
  </div>
</div>

 
>>>>>>> e6c151e7d07453c770ab3d5f051babbc08b02800
</body>

</html>