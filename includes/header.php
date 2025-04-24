<?php

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
include '../config/conexion.php';
// Aquí puedes mostrar el contenido que solo debe ser visible para usuarios autenticados
$nombre_empleado=$_SESSION['nombre_empleado'];
$id_usuario= $_SESSION['id_usuario'];
$id_rol=$_SESSION['id_rol'];


$query = "SELECT * FROM roles WHERE id_rol = :id_rol";
$stmt = $conexion->prepare($query);

// Ejecutar la consulta con el parámetro id_rol
$stmt->execute(['id_rol' => $id_rol]);


    $rol = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['nombre_rol']=$rol['nombre_rol'];
    
    $rol=$rol['nombre_rol'];


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
          <span class="fw-semibold"><i class="bi bi-person-circle me-1"></i><?= $_SESSION['usuario'] ?? 'Usuario' ?></span>
          <span class="badge bg-light text-dark text-capitalize"><i class="bi bi-shield-lock-fill me-1"></i><?= $rol ?></span>
        </div>
      </nav>
    </header>