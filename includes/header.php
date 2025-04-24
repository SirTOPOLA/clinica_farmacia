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



    
.alert {
    padding: 10px;
    margin: 15px 0;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    width: 100%;
    max-width: 500px;
}
.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.error   { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }


  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="index.php" class="nav-link active">
          <i class="bi bi-house-door"></i> Dashboard
        </a>
      </li>
       
     
      <li class="nav-item"><a href="listar_log.php" class="nav-link"><i class="bi bi-person-circle"></i> log</a></li>
      <li class="nav-item"><a href="listar_pruebas.php" class="nav-link"><i class="bi bi-person-circle"></i> pruebas</a></li>
      <li class="nav-item"><a href="listar_triaje.php" class="nav-link"><i class="bi bi-person-circle"></i> triaje</a></li>
      <li class="nav-item"><a href="listar_notificaciones.php" class="nav-link"><i class="bi bi-person-circle"></i> notificaciones</a></li>
      <li class="nav-item"><a href="listar_farmacia.php" class="nav-link"><i class="bi bi-person-circle"></i> farmacia</a></li>
      <li class="nav-item"><a href="listar_laboratorio.php" class="nav-link"><i class="bi bi-person-circle"></i> laboratorio</a></li>
      <li class="nav-item"><a href="listar_tratamiento.php" class="nav-link"><i class="bi bi-person-circle"></i> tratamiento</a></li>
      <li class="nav-item"><a href="listar_receta.php" class="nav-link"><i class="bi bi-person-circle"></i> receta</a></li>
      <li class="nav-item"><a href="listar_historial.php" class="nav-link"><i class="bi bi-person-circle"></i> Historial</a></li>
      <li class="nav-item"><a href="listar_cita.php" class="nav-link"><i class="bi bi-person-circle"></i> Citas</a></li>
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
