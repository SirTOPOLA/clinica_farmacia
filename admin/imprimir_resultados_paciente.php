<?php
require_once '../config/conexion.php';

$codigo = $_GET['codigo_paciente'] ?? '';
$fecha = $_GET['fecha'] ?? '';

if (empty($codigo)) {
  die("Código de paciente no proporcionado.");
}

// Buscar paciente
$stmt = $conexion->prepare("SELECT id_paciente, nombre FROM pacientes WHERE codigo = ?");
$stmt->execute([$codigo]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
  die("Paciente no encontrado.");
}

$id_paciente = $paciente['id_paciente'];
$nombre_paciente = $paciente['nombre'];

// Obtener pruebas del laboratorio
$query = "
  SELECT l.*, pr.nombre AS nombre_prueba, pr.precio 
  FROM laboratorio l
  JOIN pruebas_medicas pr ON l.tipo_prueba = pr.id_prueba
  WHERE l.id_paciente = ?" . (!empty($fecha) ? " AND l.fecha = ?" : "");

$stmt = $conexion->prepare($query);
!empty($fecha) ? $stmt->execute([$id_paciente, $fecha]) : $stmt->execute([$id_paciente]);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total pagado
$total_pagado = 0;
foreach ($resultados as $r) {
  if ($r['pagado'] == 1 && isset($r['precio'])) {
    $total_pagado += floatval($r['precio']);
  }
}

// Generar código QR
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
        margin: 20mm;
      }
      .no-print { display: none !important; }
      .page-break { page-break-before: always; }
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
    }

    .container {
      width: 100%;
    }

    .titulo {
      text-align: center;
      font-size: 20px;
      color: #007BFF;
      margin-bottom: 15px;
    }

    .resultado {
      margin-bottom: 15px;
      padding: 12px;
      border-left: 4px solid #007BFF;
      background-color: #f8f9fa;
    }

    .cabecera {
      display: flex;
      justify-content: space-between;
      border-bottom: 2px solid #007BFF;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .total {
      text-align: right;
      font-weight: bold;
      margin-top: 20px;
    }

    .qr {
      text-align: right;
      margin-top: 20px;
    }

    .footer {
      text-align: center;
      font-size: 11px;
      margin-top: 30px;
      color: #777;
    }

    .content-container {
      page-break-before: always;
    }

    .header-buttons {
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="no-print mb-4 text-center header-buttons">
    <a href="vista_laboratorio.php" class="btn btn-secondary">Volver</a>
    <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
    <a href="generar_pdf.php?codigo_paciente=<?= urlencode($codigo) ?>&fecha=<?= urlencode($fecha) ?>" class="btn btn-success">Generar PDF</a>
  </div>

  <div class="container">
    <div class="cabecera">
      <img src="../img/logo_medlife.png" height="50">
      <div>
        <strong>Clínica MEDLIFE</strong><br>
        Comprometidos con tu salud
      </div>
    </div>

    <div class="titulo">Resultados de Laboratorio</div>

    <p><strong>Paciente:</strong> <?= htmlspecialchars($nombre_paciente) ?></p>
    <p><strong>Código:</strong> <?= htmlspecialchars($codigo) ?></p>
    <?php if ($fecha): ?>
      <p><strong>Fecha:</strong> <?= htmlspecialchars($fecha) ?></p>
    <?php endif; ?>

    <?php if (count($resultados) > 0): ?>
      <?php foreach ($resultados as $index => $r): ?>
        <?php if ($index > 0 && $index % 3 == 0): ?>
          <div class="page-break"></div>
        <?php endif; ?>
        <div class="resultado">
          <p><strong>Fecha:</strong> <?= htmlspecialchars($r['fecha']) ?></p>
          <p><strong>Prueba:</strong> <?= htmlspecialchars($r['nombre_prueba']) ?></p>
          <p><strong>Resultado:</strong><br><?= nl2br(htmlspecialchars($r['resultado'])) ?></p>
          <p><strong>Observaciones:</strong><br><?= nl2br(htmlspecialchars($r['observaciones'])) ?></p>
          <?php if ($r['pagado'] == 1): ?>
            <p><strong>Precio:</strong> <?= number_format($r['precio'], 2) ?> FCFA</p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="total">Total pagado: <?= number_format($total_pagado, 2) ?> FCFA</div>
    <?php else: ?>
      <p>No se encontraron resultados para este paciente.</p>
    <?php endif; ?>

    <div class="qr">
      <img src="data:image/png;base64,<?= $qrBase64 ?>" height="100">
    </div>

    <div class="footer">
      © <?= date('Y') ?> Clínica MEDLIFE - Todos los derechos reservados.
    </div>
  </div>
</body>
</html>
