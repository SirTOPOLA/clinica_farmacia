<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Clínica y Farmacia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Roboto', sans-serif;
      overflow: hidden;
    }
    .navbar {
      height: 60px;
      position: fixed;
      top: 0;
      left: 260px;
      right: 0;
      background-color: #2196f3;
      color: white;
      display: flex;
      align-items: center;
      padding: 0 20px;
      z-index: 1040;
    }
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100%;
      background: #1565c0;
      padding-top: 60px;
      overflow-y: auto;
      color: white;
    }
    .sidebar .nav-link {
      color: white;
      padding: 12px 20px;
      display: flex;
      align-items: center;
      transition: background-color 0.2s ease;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background-color: rgba(255,255,255,0.1);
    }
    .sidebar i {
      margin-right: 10px;
    }
    .main-content {
      margin-left: 260px;
      margin-top: 60px;
      height: calc(100vh - 60px);
      overflow-y: auto;
      padding: 30px;
      background-color: #f1f5f9;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .header .logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: #333;
    }
    .header .user-info {
      color: #666;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="#dashboard" class="nav-link active">
          <i class="bi bi-house-door"></i> Dashboard
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-hospital"></i> Clínica
        </a>
        <ul class="dropdown-menu bg-light">
          <li><a class="dropdown-item" href="#pacientes"><i class="bi bi-person"></i> Pacientes</a></li>
          <li><a class="dropdown-item" href="#citas"><i class="bi bi-calendar-check"></i> Citas</a></li>
          <li><a class="dropdown-item" href="#medicos"><i class="bi bi-person-badge"></i> Médicos</a></li>
          <li><a class="dropdown-item" href="#historiales"><i class="bi bi-journal-medical"></i> Historial</a></li>
          <li><a class="dropdown-item" href="#servicios"><i class="bi bi-cogs"></i> Servicios</a></li>
          <li><a class="dropdown-item" href="#facturacion"><i class="bi bi-file-earmark"></i> Facturación</a></li>
          <li><a class="dropdown-item" href="#reportes"><i class="bi bi-bar-chart-line"></i> Reportes</a></li>
          <li><a class="dropdown-item" href="#aseguradoras"><i class="bi bi-shield-lock"></i> Aseguradoras</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-shop"></i> Farmacia
        </a>
        <ul class="dropdown-menu bg-light">
          <li><a class="dropdown-item" href="#productos"><i class="bi bi-box"></i> Productos</a></li>
          <li><a class="dropdown-item" href="#proveedores"><i class="bi bi-person-lines-fill"></i> Proveedores</a></li>
          <li><a class="dropdown-item" href="#ventas"><i class="bi bi-cash"></i> Ventas</a></li>
          <li><a class="dropdown-item" href="#stock"><i class="bi bi-journal-check"></i> Stock</a></li>
          <li><a class="dropdown-item" href="#reportesFarmacia"><i class="bi bi-file-earmark"></i> Reportes</a></li>
        </ul>
      </li>
      <li class="nav-item"><a href="listar_paciente.php" class="nav-link"><i class="bi bi-person-circle"></i> Pacientes</a></li>
      <li class="nav-item"><a href="listar_empleado.php" class="nav-link"><i class="bi bi-person-circle"></i> Empleados</a></li>
      <li class="nav-item"><a href="listar_usuario.php" class="nav-link"><i class="bi bi-person-circle"></i> Usuarios</a></li>
      <li class="nav-item"><a href="#configuracion" class="nav-link"><i class="bi bi-gear"></i> Configuración</a></li>
      <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-box-arrow-right"></i> Salir</a></li>
    </ul>
  </aside>

  <!-- Navbar -->
  <nav class="navbar">
    <span class="navbar-brand mb-0 h1 text-white">Clínica y Farmacia</span>
  </nav>
