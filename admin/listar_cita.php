<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");


$id_usuario = $_SESSION['id_usuario'];

// Obtener el rol
$sql = "SELECT UPPER(r.nombre_rol) AS roles FROM usuarios u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$rol_usuario = $usuario ? $usuario['roles'] : '';

try {
  $sql = "
  SELECT c.id_cita, c.recordatorio_enviado, 
         p.nombre AS nombre_paciente, p.apellido AS apellido_paciente,
         e.nombre AS nombre_medico, e.apellido AS apellido_medico,
         c.fecha_cita, c.hora_cita, c.estado
  FROM citas c
  INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
  INNER JOIN empleados e ON c.id_empleado = e.id_empleado
  WHERE CONCAT(c.fecha_cita, ' ', c.hora_cita) >= NOW()
  ORDER BY c.fecha_cita ASC, c.hora_cita ASC
";
  $stmt = $conexion->query($sql);
  $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $proxima_cita = $citas[0] ?? null;

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
        <button class="btn btn-light text-primary shadow-sm rounded-3" onclick="window.location='registrar_cita.php'" title="Registrar nueva cita">
          <span class="material-icons">add</span>
        </button>
      </div>

      <div id="alert-container" class="mb-3">
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
      </div>

      <div class="card-body bg-light">
        <div class="row mb-3 justify-content-center">
          <div class="col-md-6">
            <input type="text" id="buscar" class="form-control shadow-sm rounded" placeholder="🔍 Buscar por paciente, empleado o estado...">
          </div>
        </div>



        <?php if ($proxima_cita): ?>
          <div class="alert alert-info d-flex align-items-center justify-content-between shadow-sm rounded">
            <div>
              <strong>📅 Próxima cita:</strong>
              <?= htmlspecialchars($proxima_cita['nombre_paciente'] . ' ' . $proxima_cita['apellido_paciente']) ?>
              con el Dr. <?= htmlspecialchars($proxima_cita['nombre_medico'] . ' ' . $proxima_cita['apellido_medico']) ?>
              el <strong><?= htmlspecialchars($proxima_cita['fecha_cita']) ?></strong> a las <strong><?= htmlspecialchars($proxima_cita['hora_cita']) ?></strong>.
            </div>
            <span class="material-icons text-primary">notifications_active</span>
          </div>
        <?php endif; ?>




        <div id="tabla-citas" class="table-responsive">
          <table class="table table-sm table-striped table-hover shadow-sm rounded text-center">
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
            <tbody id="citas-tbody">
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
                        <?= ucfirst(htmlspecialchars($cita['estado'])) ?>
                      </span>
                    </td>
                    <td>
                      <?= $cita['recordatorio_enviado'] ? '<span class="text-success">✅ Enviado</span>' : '<span class="text-muted">⏳ No</span>' ?>
                    </td>
                    <td>
                      <a href="editar_cita.php?id=<?= $cita['id_cita'] ?>" class="btn btn-sm btn-outline-primary" title="Editar cita">
                        <span class="material-icons">edit</span>
                      </a>
                      <?php if ($rol_usuario === 'ADMINISTRADOR'): ?>
                        <a href="eliminar_cita.php?id=<?= $cita['id_cita'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta cita?')" title="Eliminar cita">
                          <span class="material-icons">delete</span>
                        </a>
                      <?php endif; ?>
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

        <div id="paginacion" class="d-flex justify-content-center mt-3">
          <!-- Aquí se puede implementar paginación con JS o PHP -->
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById("buscar").addEventListener("input", function() {
    const texto = this.value.toLowerCase();
    const filas = document.querySelectorAll("#citas-tbody tr");

    filas.forEach(fila => {
      const contenido = fila.innerText.toLowerCase();
      fila.style.display = contenido.includes(texto) ? "" : "none";
    });
  });
</script>



<!-- Enlazar Bootstrap JS y dependencias -->
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

</body>

</html>