<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
require_once("../config/conexion.php");

// Validar que se haya enviado un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Cita no encontrada.";
    header("Location: listar_cita.php");
    exit();
}

$id_cita = $_GET['id'];

// Obtener datos de la cita
$sql = "SELECT c.*, p.nombre AS paciente_nombre, p.apellido AS paciente_apellido
        FROM citas c
        INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
        WHERE id_cita = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_cita]);
$cita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cita) {
    $_SESSION['error'] = "Cita no encontrada.";
    header("Location: listar_cita.php");
    exit();
}

// Obtener médicos activos
$sqlMedicos = "SELECT e.id_empleado, e.nombre, e.apellido
               FROM empleados e
               INNER JOIN usuarios u ON e.codigo_empleado = u.codigo_empleado
               INNER JOIN roles r ON u.id_rol = r.id_rol
               WHERE r.nombre_rol = 'MEDICO' AND u.activo = TRUE
               ORDER BY e.nombre";
$medicos = $conexion->query($sqlMedicos)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-warning text-dark rounded-top-4">
      <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Cita</h5>
    </div>
    <div class="card-body">

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form action="../php/actualizar_cita.php" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">

        <!-- Paciente (solo lectura) -->
        <div class="mb-3">
          <label class="form-label">Paciente</label>
          <input type="text" class="form-control" value="<?php echo $cita['id_paciente'] . ' - ' . $cita['paciente_nombre'] . ' ' . $cita['paciente_apellido']; ?>" disabled>
          <input type="hidden" name="id_paciente" value="<?php echo $cita['id_paciente']; ?>">
        </div>

        <!-- Médico -->
        <div class="mb-3">
          <label for="empleado" class="form-label">Médico</label>
          <select class="form-select" id="empleado" name="id_empleado" required>
            <option value="">Seleccione un médico</option>
            <?php foreach ($medicos as $medico): ?>
              <option value="<?php echo $medico['id_empleado']; ?>" <?php if ($cita['id_empleado'] == $medico['id_empleado']) echo 'selected'; ?>>
                <?php echo $medico['nombre'] . ' ' . $medico['apellido']; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Seleccione un médico.</div>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
          <label for="fecha_cita" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" value="<?php echo $cita['fecha_cita']; ?>" required>
        </div>

        <!-- Hora -->
        <div class="mb-3">
          <label for="hora_cita" class="form-label">Hora</label>
          <input type="time" class="form-control" id="hora_cita" name="hora_cita" value="<?php echo $cita['hora_cita']; ?>" required>
        </div>

        <!-- Estado -->
        <div class="mb-3">
          <label for="estado" class="form-label">Estado</label>
          <select class="form-select" id="estado" name="estado" required>
            <option value="pendiente" <?php if ($cita['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="confirmada" <?php if ($cita['estado'] == 'confirmada') echo 'selected'; ?>>Confirmada</option>
            <option value="cancelada" <?php if ($cita['estado'] == 'cancelada') echo 'selected'; ?>>Cancelada</option>
            <option value="completada" <?php if ($cita['estado'] == 'completada') echo 'selected'; ?>>Completada</option>
          </select>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between">
          <a href="listar_cita.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Cancelar
          </a>
          <button type="submit" class="btn btn-warning">
            <i class="bi bi-save me-1"></i> Actualizar Cita
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
    // Bootstrap validation
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', e => {
                if (!form.checkValidity()) {
                    e.preventDefault()
                    e.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
