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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Panel de gestión profesional para una clínica y farmacia.">
  <meta name="keywords" content="clínica, farmacia, gestión médica, sistema de salud, dashboard">
  <meta name="author" content="Jesús Crispín Topolá Boñaho">
  <meta property="og:title" content="Panel de Clínica y Farmacia">
  <meta property="og:description" content="Sistema completo para gestionar una clínica y su farmacia.">
  <meta property="og:type" content="website">
  <meta property="og:image" content="../assets/img/preview.jpg">
  <meta property="og:url" content="https://tusitio.com/dashboard">
  <meta name="robots" content="noindex, nofollow">
  <title>Dashboard | Clínica y Farmacia</title>
  <link rel="icon" href="../assets/img/favicon.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <style>
   
  </style>
</head>

<body>
  <div class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <header>
      <nav class="navbar navbar-expand-lg bg-light shadow px-4 mb-4 d-flex justify-content-between align-items-center">
        <button class="btn toggle-btn d-lg-none me-2" onclick="document.querySelector('.sidebar').classList.toggle('show')">
          <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand mb-0 h1 text-dark d-flex align-items-center">
          <i class="bi bi-hospital-fill me-2"></i> Clínica y Farmacia
        </span>
        <div class="ms-auto d-flex align-items-center gap-3 text-dark">
          <span class="fw-semibold"><i class="bi bi-person-circle me-1"></i><?= $nombre_empleado ?? 'Usuario' ?></span>
          <span class="badge bg-light text-dark text-capitalize"><i class="bi bi-shield-lock-fill me-1"></i><?= $rol ?></span>
        </div>
      </nav>
    </header>