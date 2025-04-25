<?php

session_start();
include '../config/conexion.php'; // Asegúrate de que esta ruta es correcta y que $conexion es una instancia PDO

$id_usuario = $_SESSION['id_usuario'] ?? 0;

$nombre_empleado = "Desconocido";
$rol = "sin rol";

if ($id_usuario > 0) {
    $sql = "SELECT CONCAT(e.nombre, ' ', e.apellido) AS nombre_empleado, r.nombre_rol
            FROM usuarios u
            JOIN empleados e ON u.codigo_empleado = e.codigo_empleado
            JOIN roles r ON u.id_rol = r.id_rol
            WHERE u.id_usuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nombre_empleado = $row['nombre_empleado'];
        $rol = strtolower($row['nombre_rol']);
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Codificación y compatibilidad -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Responsividad -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- SEO básico -->
  <title>Dashboard | Clínica y Farmacia</title>
  <meta name="description" content="Sistema web profesional para la gestión completa de una clínica y farmacia, con panel administrativo moderno, seguro y responsivo.">
  <meta name="keywords" content="clínica, farmacia, salud, gestión médica, sistema web, panel administrativo, pacientes, empleados, medicamentos">
  <meta name="author" content="Jesús Crispín Topolá Boñaho">
  <meta name="robots" content="index, follow">

  <!-- Open Graph (para compartir en redes sociales como Facebook, WhatsApp) -->
  <meta property="og:title" content="Panel de Clínica y Farmacia">
  <meta property="og:description" content="Gestiona fácilmente una clínica y su farmacia desde un solo lugar.">
  <meta property="og:type" content="website">
  <meta property="og:image" content="https://tusitio.com/assets/img/preview.jpg">
  <meta property="og:url" content="https://tusitio.com/dashboard">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Panel de Clínica y Farmacia">
  <meta name="twitter:description" content="Sistema completo para clínicas y farmacias.">
  <meta name="twitter:image" content="https://tusitio.com/assets/img/preview.jpg">
  <meta name="twitter:site" content="@TuUsuarioTwitter">

  <!-- Icono -->
  <link rel="icon" href="https://tusitio.com/assets/img/favicon.png" type="image/png">

  <!-- Estilos y fuentes -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">

  <!-- Lenguaje estructurado (opcional, mejora SEO) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "Sistema Clínica y Farmacia",
    "url": "https://tusitio.com/dashboard",
    "author": {
      "@type": "Person",
      "name": "Salvador Mete y J.C. Topolá"
    },
    "applicationCategory": "HealthApplication",
    "operatingSystem": "Web",
    "description": "Aplicación web para la gestión de clínicas y farmacias con funciones avanzadas de administración, triaje, inventario, pacientes y empleados.",
    "image": "https://tusitio.com/assets/img/preview.jpg"
  }
  </script>
</head>

<!-- Header fijo -->
<!-- <header class="header">
    <nav class="navbar navbar-expand-lg bg-primary shadow-sm px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-light d-lg-none me-2" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <span class="navbar-brand mb-0 h1 text-white d-flex align-items-center">
                <i class="bi bi-hospital-fill me-2"></i> Clínica y Farmacia
            </span>
        </div>
        <div class="ms-auto d-flex align-items-center gap-3 text-white">
             
        </div>
    </nav>
</header>
 -->
 
<header class="header">
    <nav class="navbar navbar-expand-lg bg-primary shadow-sm px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-light d-lg-none me-2" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
            <span class="navbar-brand mb-0 h1 text-white d-flex align-items-center">
                <i class="bi bi-hospital-fill me-2"></i> Clínica y Farmacia
            </span>
        </div>
        <div class="ms-auto d-flex align-items-center gap-3 text-white">
            <span class="fw-semibold"><i class="bi bi-person-circle me-1"></i><?= $nombre_empleado ?? 'Usuario' ?></span>
            <span class="badge bg-light text-primary text-capitalize"><i class="bi bi-shield-lock-fill me-1"></i><?= $rol ?></span>
        </div>
    </nav>
</header>