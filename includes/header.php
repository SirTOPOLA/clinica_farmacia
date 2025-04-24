<?php
session_start();
$rol = $_SESSION['rol'] ?? 'administrador'; // Por defecto, resección si no está definido
$pagina = basename($_SERVER['PHP_SELF']);

function activo($archivo)
{
  global $pagina;
  return $pagina === $archivo ? 'active' : '';
}

$accesos = [
  'reseccion' => [
    ['listar_paciente.php', 'bi bi-people', 'Pacientes'],
    ['listar_farmacia.php', 'bi bi-capsule', 'Farmacia'],
    ['listar_cita.php', 'bi bi-calendar-event', 'Citas'],
  ],
  'enfermera' => [
    ['listar_triaje.php', 'bi bi-heart-pulse', 'Triaje'],
    ['listar_tratamiento.php', 'bi bi-clipboard2-pulse', 'Tratamiento'],
  ],
  'medico' => [
    ['listar_pruebas.php', 'bi bi-file-medical', 'Pruebas Médicas'],
    ['listar_laboratorio.php', 'bi bi-beaker', 'Laboratorio'],
    ['listar_receta.php', 'bi bi-prescription', 'Recetas'],
    ['listar_cita.php', 'bi bi-calendar-event', 'Citas'],
  ],
  'laboratorio' => [
    ['listar_laboratorio.php', 'bi bi-beaker', 'Laboratorio'],
  ],
  'administrador' => [
    ['index.php', 'bi bi-house-door', 'Dashboard'],
    ['listar_log.php', 'bi bi-journal-text', 'Log'],
    ['listar_pruebas.php', 'bi bi-file-medical', 'Pruebas'],
    ['listar_triaje.php', 'bi bi-heart-pulse', 'Triaje'],
    ['listar_notificaciones.php', 'bi bi-bell', 'Notificaciones'],
    ['listar_farmacia.php', 'bi bi-capsule', 'Farmacia'],
    ['listar_laboratorio.php', 'bi bi-beaker', 'Laboratorio'],
    ['listar_tratamiento.php', 'bi bi-clipboard2-pulse', 'Tratamiento'],
    ['listar_receta.php', 'bi bi-prescription', 'Recetas'],
    ['listar_historial.php', 'bi bi-clock-history', 'Historial'],
    ['listar_cita.php', 'bi bi-calendar-event', 'Citas'],
    ['listar_paciente.php', 'bi bi-people', 'Pacientes'],
    ['listar_empleado.php', 'bi bi-person-badge', 'Empleados'],
    ['listar_usuario.php', 'bi bi-person-gear', 'Usuarios'],
    ['#configuracion', 'bi bi-gear', 'Configuración'],
  ],
];

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Clínica y Farmacia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    html,
    body {
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

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: rgba(255, 255, 255, 0.1);
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
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }




    /* Estilo para el Modal */
.modal-content {
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

/* Títulos e íconos */
.modal-header {
  background-color: #007bff;
  color: white;
}

.modal-title {
  font-size: 1.25rem;
}

.modal-footer {
  border-top: 1px solid #ddd;
}

.modal-footer .btn {
  font-size: 1rem;
}

/* Botones con íconos */
.btn-light {
  background-color: #f8f9fa;
  color: #6c757d;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.btn-danger {
  background-color: #dc3545;
  border-color: #dc3545;
}

.btn-warning {
  background-color: #ffc107;
  border-color: #ffc107;
}

/* Íconos */
.bi {
  margin-right: 8px;
}




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

      <?php
      // Imprime enlaces según rol
      $enlaces = $accesos[$rol] ?? [];

      foreach ($enlaces as [$url, $icono, $nombre]) {
        echo "<li class='nav-item'>
          <a href='$url' class='nav-link " . activo($url) . "'>
            <i class='$icono'></i> $nombre
          </a>
        </li>";
      }
      ?>

      <!-- Opción común para todos los roles -->
      <li class="nav-item">
        <a href="logout.php" class="nav-link">
          <i class="bi bi-box-arrow-right"></i> Salir
        </a>
      </li>
    </ul>
  </aside>

  <!-- Navbar -->
  <nav class="navbar">
    <span class="navbar-brand mb-0 h1 text-white">Clínica y Farmacia</span>
  </nav>