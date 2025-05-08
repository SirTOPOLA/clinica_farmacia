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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
      background-color: #f4f6f9;
    }

    .container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .titulo {
      text-align: center;
      font-size: 24px;
      color: #007BFF;
      font-weight: bold;
      margin-bottom: 25px;
    }

    .resultado {
      margin-bottom: 20px;
      padding: 1rem;
      border-left: 5px solid #007BFF;
      background-color: #f8f9fa;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .cabecera {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #007BFF;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }

    .cabecera img {
      max-height: 60px;
    }

    .total {
      text-align: right;
      font-size: 1.1rem;
      font-weight: bold;
      color: #28a745;
      margin-top: 30px;
    }

    .qr {
      text-align: right;
      margin-top: 30px;
    }

    .footer {
      text-align: center;
      font-size: 11px;
      margin-top: 40px;
      color: #777;
      border-top: 1px solid #dee2e6;
      padding-top: 10px;
    }

    .header-buttons {
      text-align: center;
      margin-bottom: 20px;
    }

    .header-buttons .btn {
      margin: 0 5px;
    }

    .dato {
      font-weight: 500;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="no-print header-buttons">
    <a href="listar_laboratorio.php" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
    <button onclick="window.print()" class="btn btn-outline-primary">
      <i class="bi bi-printer"></i> Imprimir
    </button>
    <a href="generar_pdf.php?codigo_paciente=<?= urlencode($codigo) ?>&fecha=<?= urlencode($fecha) ?>" class="btn btn-outline-success">
      <i class="bi bi-file-earmark-pdf"></i> Generar PDF
    </a>
  </div>

  <div class="container mt-2">
    <div class="cabecera">
      <img src="../img/logo_medlife.png" alt="Logo">
      <div class="text-end">
        <h5 class="mb-0 text-primary">Clínica MEDLIFE</h5>
        <small class="text-muted">Comprometidos con tu salud</small>
      </div>
    </div>

    <div class="titulo">Resultados de Laboratorio</div>

    <p class="dato"><i class="bi bi-person-fill text-primary"></i> <strong>Paciente:</strong> <?= htmlspecialchars($nombre_paciente) ?></p>
    <p class="dato"><i class="bi bi-upc-scan text-primary"></i> <strong>Código:</strong> <?= htmlspecialchars($codigo) ?></p>
    <?php if ($fecha): ?>
      <p class="dato"><i class="bi bi-calendar-event text-primary"></i> <strong>Fecha:</strong> <?= htmlspecialchars($fecha) ?></p>
    <?php endif; ?>

    <?php if (count($resultados) > 0): ?>
      <?php foreach ($resultados as $index => $r): ?>
        <?php if ($index > 0 && $index % 3 == 0): ?>
          <div class="page-break"></div>
        <?php endif; ?>
        <div class="resultado">
          <p><i class="bi bi-calendar-week"></i> <strong>Fecha:</strong> <?= htmlspecialchars($r['fecha']) ?></p>
          <p><i class="bi bi-clipboard2-pulse"></i> <strong>Prueba:</strong> <?= htmlspecialchars($r['nombre_prueba']) ?></p>
          <p><i class="bi bi-activity"></i> <strong>Resultado:</strong><br><?= nl2br(htmlspecialchars($r['resultado'])) ?></p>
          <?php if ($r['pagado'] == 1): ?>
            <p><i class="bi bi-currency-exchange"></i> <strong>Precio:</strong> <?= number_format($r['precio'], 2) ?> FCFA</p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="total">
        <i class="bi bi-cash-coin"></i> Total pagado: <?= number_format($total_pagado, 2) ?> FCFA
      </div>
    <?php else: ?>
      <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle"></i> No se encontraron resultados para este paciente.
      </div>
    <?php endif; ?>

    <div class="mt-5" style="margin-top: 60px;">
  <div class="row">
    <div class="col-6 text-start">
      <p><strong>Firma del Médico:</strong></p>
      <div style="border-bottom: 1px solid #000; width: 250px; height: 40px;"></div>
      <p class="mt-2 text-muted">Nombre y firma</p>
    </div>
  </div>
</div>


    <div class="qr">
      <img src="data:image/png;base64,<?= $qrBase64 ?>" height="100" alt="Código QR">
    </div>

    <div class="footer">
      © <?= date('Y') ?> Clínica MEDLIFE - Todos los derechos reservados.
    </div>
  </div>
</body>
</html>
