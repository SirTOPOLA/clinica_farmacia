<?php
require_once("../includes/header.php");
require_once("../includes/sidebar.php");


// Seguridad: validación estricta del rol
$roles_permitidos = ['recepcion', 'medico', 'laboratorio', 'administrador','enfermera'];
if (!isset($rol) || !in_array($rol, $roles_permitidos)) {
    http_response_code(403);
    exit('Acceso denegado');
}

// Inicialización de variables seguras
$pacientes_count = 0;
$citas_hoy_count = 0;
$laboratorio_pendientes = 0;

// Seguridad adicional: zona try-catch para manejar errores silenciosamente
try {
    $hoy = date("Y-m-d");

    // Pacientes registrados
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM pacientes");
    $stmt->execute();
    $pacientes_count = (int)$stmt->fetchColumn();

    // Citas de hoy con estado 'pendiente' o 'confirmada'
    $stmt = $conexion->prepare("
        SELECT COUNT(*) 
        FROM citas 
        WHERE fecha_cita = :hoy 
        AND estado IN ('pendiente', 'confirmada')
    ");
    $stmt->execute([':hoy' => $hoy]);
    $citas_hoy_count = (int)$stmt->fetchColumn();

    // Pendientes en laboratorio (sin resultado)
    $stmt = $conexion->prepare("
        SELECT COUNT(*) 
        FROM laboratorio 
        WHERE resultado IS NULL OR TRIM(resultado) = ''
    ");
    $stmt->execute();
    $laboratorio_pendientes = (int)$stmt->fetchColumn();

} catch (PDOException $e) {
    error_log("Error en dashboard.php: " . $e->getMessage());
    // Mensaje genérico para el usuario (sin exponer detalles internos)
    $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Hubo un problema al cargar los datos. Intenta más tarde.'];
}
?>

<main class="main-content">
  <div class="conten-wrapper">
    <?php include_once("../components/alerta.php"); ?>

    <div class="row g-4">
      <?php if (in_array($rol, ['recepcion', 'administrador'])): ?>
        <div class="col-md-4">
          <div class="card bg-primary text-white border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-people-fill display-5 me-3" aria-hidden="true"></i>
                <h5 class="mb-0">Pacientes Registrados</h5>
              </div>
              <p class="display-6 fw-bold text-end"><?= number_format($pacientes_count) ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (in_array($rol, ['medico', 'administrador'])): ?>
        <div class="col-md-4">
          <div class="card bg-success text-white border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-calendar-check-fill display-5 me-3" aria-hidden="true"></i>
                <h5 class="mb-0">Citas de Hoy</h5>
              </div>
              <p class="display-6 fw-bold text-end"><?= number_format($citas_hoy_count) ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php if (in_array($rol, ['laboratorio', 'administrador'])): ?>
        <div class="col-md-4">
          <div class="card bg-danger text-white border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-flask display-5 me-3" aria-hidden="true"></i>
                <h5 class="mb-0">Pendientes en Laboratorio</h5>
              </div>
              <p class="display-6 fw-bold text-end"><?= number_format($laboratorio_pendientes) ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php include_once("../includes/footer.php"); ?>

<!-- Scripts JS diferidos para rendimiento -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="../assets/js/main.js" defer></script>
<script src="../assets/js/sidebar.js" defer></script>
</body>
</html>
