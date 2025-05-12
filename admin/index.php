<?php
require_once("../includes/header.php");
require_once("../includes/sidebar.php");


// Seguridad: validación estricta del rol
$roles_permitidos = ['recepcion', 'medico', 'laboratorio', 'administrador', 'enfermera'];
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



  // Consultar el total de citas en el sistema
  $stmt = $conexion->prepare("SELECT COUNT(*) FROM citas");
  $stmt->execute();
  $total_citas = (int)$stmt->fetchColumn();

  // Pendientes en laboratorio (sin resultado)
  $stmt = $conexion->prepare("
    SELECT COUNT(*) 
    FROM pruebas_medicas
");
  $stmt->execute();
  $total_pruebas_medicas = (int)$stmt->fetchColumn();
} catch (PDOException $e) {
  error_log("Error en dashboard.php: " . $e->getMessage());
  // Mensaje genérico para el usuario (sin exponer detalles internos)
  $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Hubo un problema al cargar los datos. Intenta más tarde.'];
}


// Inicialización de variables seguras para triajes
$triajes_mes_count = 0;
$triajes_mes_total_precio = 0;
$nombre_mes = date("F"); // Obtener el nombre del mes, en inglés

// Array de nombres de meses en español
$meses = [
  "January" => "Enero",
  "February" => "Febrero",
  "March" => "Marzo",
  "April" => "Abril",
  "May" => "Mayo",
  "June" => "Junio",
  "July" => "Julio",
  "August" => "Agosto",
  "September" => "Septiembre",
  "October" => "Octubre",
  "November" => "Noviembre",
  "December" => "Diciembre"
];

// Cambiar el nombre del mes a español
$nombre_mes = $meses[$nombre_mes];

// Seguridad: Agregar try-catch para manejar errores
try {
  // Consultar el total de triajes y la suma de los precios por mes
  $stmt = $conexion->prepare("
    SELECT COUNT(*), SUM(precio)
    FROM triaje
    WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())
  ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $triajes_mes_count = (int)$result['COUNT(*)'];
  $triajes_mes_total_precio = (float)$result['SUM(precio)'];
} catch (PDOException $e) {
  error_log("Error en dashboard.php al obtener triajes: " . $e->getMessage());
  $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Hubo un problema al cargar los datos de triaje. Intenta más tarde.'];
}


// Inicialización de variables seguras para triajes
$triajes_mes_count = 0;
$triajes_mes_total_precio = 0;

try {
  // Consultar el total de triajes y la suma de los precios por mes
  $stmt = $conexion->prepare("
    SELECT COUNT(*), SUM(precio)
    FROM triaje
    WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())
  ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $triajes_mes_count = (int)$result['COUNT(*)'];
  $triajes_mes_total_precio = (float)$result['SUM(precio)'];
} catch (PDOException $e) {
  error_log("Error en dashboard.php al obtener triajes: " . $e->getMessage());
  $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Hubo un problema al cargar los datos de triaje. Intenta más tarde.'];
}


// Inicialización de variables para el laboratorio
$laboratorio_count = 0;
$laboratorio_total_precio = 0;

// Seguridad adicional: try-catch para manejar errores
try {
  // Consultar el número de registros pagados y la suma de los precios
  $stmt = $conexion->prepare("
    SELECT COUNT(l.id_resultado), SUM(p.precio) 
  FROM laboratorio l
  JOIN pruebas_medicas p ON l.tipo_prueba = p.id_prueba
  WHERE l.pagado = 1
    AND MONTH(l.fecha) = MONTH(CURRENT_DATE())
    AND YEAR(l.fecha) = YEAR(CURRENT_DATE())
  ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // Obtener los resultados de la consulta
  $laboratorio_count = (int)$result['COUNT(l.id_resultado)'];
  $laboratorio_total_precio = (float)$result['SUM(p.precio)'];
} catch (PDOException $e) {
  error_log("Error en dashboard.php al obtener datos del laboratorio: " . $e->getMessage());
  $_SESSION['alerta'] = ['tipo' => 'error', 'mensaje' => 'Hubo un problema al cargar los datos del laboratorio. Intenta más tarde.'];
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
                <h5 class="mb-0">Citas del Sistema</h5>
              </div>
              <p class="display-6 fw-bold text-end"><?= number_format($total_citas) ?></p>
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
              <p class="display-6 fw-bold text-end"><?= number_format($total_pruebas_medicas) ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Nueva tarjeta para triajes -->
      <?php if (in_array($rol, ['recepcion', 'medico', 'administrador'])): ?>
        <div class="col-md-4">
          <div class="card bg-primary text-white border-0 rounded-4 h-100 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="bi bi-file-earmark-medical display-5 me-3" aria-hidden="true"></i>
                <h5 class="mb-0">Triajes de <?= $nombre_mes ?></h5> <!-- Nombre del mes -->
              </div>
              <p class="display-6 fw-bold text-end"><?= number_format($triajes_mes_count) ?></p>
              <p class="text-end">Generado este mes: <?= number_format($triajes_mes_total_precio, 2) ?> XAF</p>
            </div>
          </div>
        </div>
      <?php endif; ?>


      <?php if (in_array($rol, ['laboratorio', 'administrador'])): ?>
  <div class="col-md-4">
    <div class="card bg-success text-white border-0 rounded-4 h-100 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center mb-3">
          <i class="bi bi-flask display-5 me-3" aria-hidden="true"></i>
          <h5 class="mb-0">Laboratorio Pagado - <?= $nombre_mes ?></h5>
        </div>
        <p class="display-6 fw-bold text-end"><?= number_format($laboratorio_count) ?></p>
        <p class="text-end">Generado: <?= number_format($laboratorio_total_precio, 2) ?> XAF</p>
      </div>
    </div>
  </div>
<?php endif; ?>


    </div>
  </div>
</main>




<?php include_once("../includes/footer.php"); ?>

<!-- Scripts JS diferidos para rendimiento -->
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js" defer></script>
<script src="../assets/js/sidebar.js" defer></script>
</body>

</html>