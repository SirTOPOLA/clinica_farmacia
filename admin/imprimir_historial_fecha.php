<?php
require_once '../config/conexion.php';

$codigo = isset($_GET['codigo_paciente']) ? trim($_GET['codigo_paciente']) : '';
$fecha = $_GET['fecha'] ?? '';

if (empty($codigo)) {
  die("Código de paciente no proporcionado.");
}

// Buscar paciente - coincidencia exacta
$stmt = $conexion->prepare("SELECT id_paciente, nombre FROM pacientes WHERE BINARY codigo = ?");
$stmt->execute([$codigo]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
  die("Paciente no encontrado con código: '$codigo'");
}

$id_paciente = $paciente['id_paciente'];
$nombre_paciente = $paciente['nombre'];

// Obtener triaje
$triaje = null;
$precio_triaje = 0;
if (!empty($fecha)) {
  $stmt = $conexion->prepare("
    SELECT t.*, u.codigo_empleado, t.precio AS precio_triaje
    FROM triaje t
    LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
    WHERE t.id_paciente = ? AND t.fecha = ?
  ");
  $stmt->execute([$id_paciente, $fecha]);
  $triaje = $stmt->fetch(PDO::FETCH_ASSOC);
  $precio_triaje = $triaje['precio_triaje'] ?? 0; // Asumimos que el triaje tiene un precio
}

// Verificar el nombre del empleado asociado al triaje
$nombre_empleado = '';
if ($triaje && isset($triaje['codigo_empleado'])) {
  $codigo_empleado = $triaje['codigo_empleado'];

  // Buscar el nombre del empleado usando el código_empleado
  $stmt = $conexion->prepare("SELECT nombre FROM empleados WHERE codigo_empleado = ?");
  $stmt->execute([$codigo_empleado]);
  $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($empleado) {
    $nombre_empleado = $empleado['nombre'];
  } else {
    $nombre_empleado = 'Empleado no encontrado';
  }
}

// Obtener receta médica
$receta = null;
$stmt = $conexion->prepare("
  SELECT * FROM recetas
  WHERE id_paciente = ? AND fecha = ?
");
$stmt->execute([$id_paciente, $fecha]);
$receta = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener resultados de laboratorio
$query = "
  SELECT l.*, pr.nombre AS nombre_prueba, pr.precio 
  FROM laboratorio l
  JOIN pruebas_medicas pr ON l.tipo_prueba = pr.id_prueba
  WHERE l.id_paciente = ?" . (!empty($fecha) ? " AND l.fecha = ?" : "");

$stmt = $conexion->prepare($query);
!empty($fecha) ? $stmt->execute([$id_paciente, $fecha]) : $stmt->execute([$id_paciente]);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total pagado
$total_pagado = $precio_triaje; // Empezamos con el precio del triaje

foreach ($resultados as $r) {
  if ($r['pagado'] == 1 && isset($r['precio'])) {
    $total_pagado += floatval($r['precio']);
  }
}

// Generar QR
require_once '../phpqrcode/qrlib.php';
$datosQR = "Paciente: $nombre_paciente\nCódigo: $codigo\nFecha: " . ($fecha ?: "Todas");
$qrTemp = tempnam(sys_get_temp_dir(), 'qr');
QRcode::png($datosQR, $qrTemp);
$qrBase64 = base64_encode(file_get_contents($qrTemp));
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultados de Laboratorio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print {
      body {
        width: 21cm;
        height: 29.7cm;
        margin: 0;
        font-family: Arial, sans-serif;
        box-shadow: none;
      }
      .no-print { display: none !important; }
      .page-break { page-break-before: always; }
      .container { padding: 0; }

      /* Estilo para secciones */
      .header { 
        text-align: center;
        margin-bottom: 20px;
      }
      .header img {
        width: 120px;
      }
      .section-title {
        text-align: center;
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: bold;
      }
      .line-separator {
        border-top: 2px solid #2980b9;
        margin: 20px 0;
      }
      
      /* Dividir en 2 columnas */
      .columns {
        display: flex;
        justify-content: space-between;
        gap: 30px;
      }
      .column {
        width: 48%;
      }

      .content {
        margin-bottom: 20px;
      }

      .resultados, .triaje, .receta {
        padding: 15px;
        background: #ecf0f1;
        border-radius: 8px;
        border: 1px solid #bdc3c7;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
      }

      .content strong {
        color: #2980b9;
      }

      .total {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        color: #2980b9;
      }

      .footer {
        text-align: center;
        font-size: 12px;
        margin-top: 30px;
        color: #7f8c8d;
      }

      .firma {
        margin-top: 30px;
        text-align: left;
        font-style: italic;
        font-size: 14px;
      }
    }

    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f6f9;
    }
  </style>
</head>
<body>

  <div class="no-print text-center mt-4">
    <a href="listar_historial_medico.php" class="btn btn-secondary">Volver</a>
    <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
    <a href="generar_pdf.php?codigo_paciente=<?= urlencode($codigo) ?>&fecha=<?= urlencode($fecha) ?>" class="btn btn-success">Generar PDF</a>
  </div>

  <div class="container page-content">
    <div class="header">
      <img src="../img/logo_medlife.png" alt="Logo">
      <h3>Clínica MEDLIFE</h3>
      <p><strong>Comprometidos con tu salud</strong></p>
    </div>

    <div class="section-title">Historial Médico del Paciente</div>

    <div class="columns">
      <!-- Columna izquierda: Datos del paciente y Triaje -->
      <div class="column">
        <div class="content">
          <h5><strong>Datos del Paciente</strong></h5>
          <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre_paciente) ?></p>
          <p><strong>Código:</strong> <?= htmlspecialchars($codigo) ?></p>
          <p><strong>Fecha:</strong> <?= htmlspecialchars($fecha) ?></p>
        </div>

        <!-- Triaje -->
        <div class="triaje">
          <h5><strong>Triaje</strong></h5>
          <?php if ($triaje): ?>
            <p><strong>Fecha:</strong> <?= htmlspecialchars($triaje['fecha']) ?></p>
            <p><strong>Hora:</strong> <?= htmlspecialchars($triaje['hora']) ?></p>
            <p><strong>Pulso:</strong> <?= htmlspecialchars($triaje['pulso']) ?></p>
            <p><strong>Temperatura:</strong> <?= htmlspecialchars($triaje['temperatura']) ?> °C</p>
            <p><strong>Peso:</strong> <?= htmlspecialchars($triaje['peso']) ?> kg</p>
            <p><strong>Presión Arterial:</strong> <?= htmlspecialchars($triaje['presion_arterial']) ?></p>
            <p><strong>Motivo:</strong><br><?= nl2br(htmlspecialchars($triaje['motivo'])) ?></p>
            <p><strong>Observaciones:</strong><br><?= nl2br(htmlspecialchars($triaje['observaciones'])) ?></p>
            <p><strong>Médico Responsable:</strong> <?= htmlspecialchars($nombre_empleado) ?></p>
            <p><strong>Precio del Triaje:</strong> <?= number_format($precio_triaje, 2) ?> FCFA</p>
          <?php else: ?>
            <p>No se encontraron datos de triaje.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Columna derecha: Resultados de laboratorio -->
      <div class="column">
        <div class="content">
          <h5><strong>Resultados de Laboratorio</strong></h5>
          <div class="line-separator"></div>

          <?php foreach ($resultados as $resultado): ?>
            <div class="resultados">
              <p><strong>Fecha:</strong> <?= htmlspecialchars($resultado['fecha']) ?></p>
              <p><strong>Prueba:</strong> <?= htmlspecialchars($resultado['nombre_prueba']) ?></p>
              <p><strong>Resultado:</strong><br><?= nl2br(htmlspecialchars($resultado['resultado'])) ?></p>
              <p><strong>Observaciones:</strong><br><?= nl2br(htmlspecialchars($resultado['observaciones'])) ?></p>
              <p><strong>Precio:</strong> <?= number_format($resultado['precio'], 2) ?> FCFA</p>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Receta Médica -->
        <?php if ($receta): ?>
          <div class="line-separator"></div>
          <div class="receta">
            <h5><strong>Receta Médica</strong></h5>
            <p><strong>Fecha:</strong> <?= htmlspecialchars($receta['fecha']) ?></p>
            <p><strong>Medicamento:</strong> <?= htmlspecialchars($receta['medicamento']) ?></p>
            <p><strong>Dosis:</strong> <?= htmlspecialchars($receta['dosis']) ?></p>
            <p><strong>Duración:</strong> <?= htmlspecialchars($receta['duracion']) ?></p>
            <p><strong>Indicaciones:</strong><br><?= nl2br(htmlspecialchars($receta['indicaciones'])) ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Total -->
    <div class="total">
      <p><strong>Total Pagado: </strong><?= number_format($total_pagado, 2) ?> FCFA</p>
    </div>

    <!-- QR -->
    <div class="qr">
      <img src="data:image/png;base64,<?= $qrBase64 ?>" height="100">
    </div>

    <!-- Firma -->
    <div class="firma">
      Firma del médico: ___________________________
    </div>

    <!-- Pie de página -->
    <div class="footer">
      © <?= date('Y') ?> Clínica MEDLIFE - Comprometidos con tu salud
    </div>
  </div>
</body>
</html>
