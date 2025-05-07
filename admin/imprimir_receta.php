<?php
require_once '../config/conexion.php';
require_once '../phpqrcode/qrlib.php'; // Asegúrate de tener esta librería

$id_receta = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_receta <= 0) die("Receta no válida.");

// Consulta
$stmt = $conexion->prepare("
    SELECT r.*, 
           CONCAT(p.nombre, ' ', p.apellido) AS nombre_paciente, 
           p.fecha_nacimiento,
           CONCAT(e.nombre, ' ', e.apellido) AS nombre_medico 
    FROM recetas r 
    JOIN pacientes p ON r.id_paciente = p.id_paciente 
    JOIN empleados e ON r.id_empleado = e.id_empleado 
    WHERE r.id_receta = :id
");
$stmt->bindParam(':id', $id_receta, PDO::PARAM_INT);
$stmt->execute();
$receta = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$receta) die("Receta no encontrada.");

// Calcular edad
$fecha_nacimiento = new DateTime($receta['fecha_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($fecha_nacimiento)->y;

// Generar QR
$qr_text = "Paciente: {$receta['nombre_paciente']}\nMedicamento: {$receta['medicamento']}\nFecha: {$receta['fecha']}";
$qr_file = 'qr_temp_' . $id_receta . '.png';
QRcode::png($qr_text, $qr_file, QR_ECLEVEL_Q, 4);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Receta Médica - MEDLIFE</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        .receta {
            max-width: 800px;
            margin: auto;
            border: 2px solid #007bff;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .header h1 {
            color: #007bff;
            font-size: 30px;
            margin: 10px 0;
        }

        .info p {
            font-size: 16px;
            margin: 4px 0;
        }

        .seccion {
            margin-bottom: 20px;
        }

        .seccion h3 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        .seccion textarea {
            font-size: 16px;
            width: 95%;
            margin-right: 10px;
            border: 1px solid #007bff;
            padding: 10px;
            resize: none;
            border-radius: 5px;
            background: #f8f9fa;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .firma {
            border-top: 2px solid #000;
            width: 200px;
            text-align: center;
            padding-top: 10px;
        }

        .eslogan {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #555;
            font-style: italic;
        }

        .qr img {
            max-width: 120px;
        }

        .botones {
            text-align: center;
            margin-bottom: 20px;
        }

        .botones button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .botones button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="botones no-print">
        <button onclick="imprimirYLimpiar()">🖨️ Imprimir</button>
        <script>
            function imprimirYLimpiar() {
                window.print();
                fetch('eliminar_qr.php?archivo=<?= $qr_file ?>')
                    .then(response => response.text())
                    .then(data => console.log(data));
            }
        </script>
        <button onclick="window.location.href='listar_receta.php'">🔙 Volver</button>
    </div>

    <div class="receta">
        <!-- Encabezado -->
        <div class="header">
            <img src="../assets/logo_medlife.png" alt="Logo MEDLIFE">
            <h1>Receta Médica</h1>
            <p><strong>Fecha de impresión:</strong> <?= date('d/m/Y') ?></p>
        </div>

        <!-- Información del paciente -->
        <div class="info">
            <p><strong>Paciente:</strong> <?= htmlspecialchars($receta['nombre_paciente']) ?></p>
            <p><strong>Edad:</strong> <?= $edad ?> años</p>
            <p><strong>Médico:</strong> <?= htmlspecialchars($receta['nombre_medico']) ?></p>
            <p><strong>Fecha de receta:</strong> <?= date('d/m/Y', strtotime($receta['fecha'])) ?></p>
        </div>

        <!-- Medicamento -->
        <div class="seccion">
            <h3>Medicamento</h3>
            <textarea rows="2" readonly><?= htmlspecialchars($receta['medicamento']) ?></textarea>
        </div>

        <!-- Instrucciones -->
        <div class="seccion">
            <h3>Instrucciones</h3>
            <textarea rows="3" readonly><?= htmlspecialchars($receta['indicaciones']) ?></textarea>
        </div>

        <!-- Duración -->
        <div class="seccion">
            <h3>Duración</h3>
            <p><?= htmlspecialchars($receta['duracion']) ?> días</p>
        </div>

        <!-- Firma y QR -->
        <div class="footer">
            <div class="firma">
                Firma del Médico
            </div>
            <div class="qr">
                <img src="<?= $qr_file ?>" alt="QR de receta">
            </div>
        </div>

        <!-- Eslogan -->
        <div class="eslogan">
            Clínica MEDLIFE — <strong>Tu salud es lo más importante</strong>
        </div>
    </div>

</body>

</html>