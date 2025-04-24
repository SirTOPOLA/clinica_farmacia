<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Clínica y Farmacia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../../frontend/css/admin.css">
 
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <span class="navbar-brand">Clínica y Farmacia</span>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" onclick="toggleSidebar()">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
     
    <!-- Sidebar Menu -->
    <ul class="nav flex-column">
      <!-- Dashboard -->
      <li class="nav-item">
        <a href="#dashboard" class="nav-link active">
          <i class="bi bi-house-door"></i> Dashboard
        </a>
      </li>
  
      <!-- Módulo de Clínica -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarClinica" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-hospital"></i> Clínica
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarClinica">
          <li><a class="dropdown-item" href="#pacientes"><i class="bi bi-person"></i> Pacientes</a></li>
          <li><a class="dropdown-item" href="#citas"><i class="bi bi-calendar-check"></i> Citas Médicas</a></li>
          <li><a class="dropdown-item" href="#medicos"><i class="bi bi-person-badge"></i> Médicos</a></li>
          <li><a class="dropdown-item" href="#historiales"><i class="bi bi-journal-medical"></i> Historial Médico</a></li>
          <li><a class="dropdown-item" href="#servicios"><i class="bi bi-cogs"></i> Servicios Médicos</a></li>
          <li><a class="dropdown-item" href="#facturacion"><i class="bi bi-file-earmark-earmark"></i> Facturación</a></li>
          <li><a class="dropdown-item" href="#reportes"><i class="bi bi-bar-chart-line"></i> Reportes</a></li>
          <li><a class="dropdown-item" href="#aseguradoras"><i class="bi bi-shield-lock"></i> Aseguradoras</a></li>
        </ul>
      </li>
  
      <!-- Módulo de Farmacia -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarFarmacia" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-shop"></i> Farmacia
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarFarmacia">
          <li><a class="dropdown-item" href="#productos"><i class="bi bi-box"></i> Productos</a></li>
          <li><a class="dropdown-item" href="#proveedores"><i class="bi bi-person-lines-fill"></i> Proveedores</a></li>
          <li><a class="dropdown-item" href="#ventas"><i class="bi bi-cash"></i> Ventas</a></li>
          <li><a class="dropdown-item" href="#stock"><i class="bi bi-journal-check"></i> Control de Stock</a></li>
          <li><a class="dropdown-item" href="#reportesFarmacia"><i class="bi bi-file-earmark-earmark"></i> Reportes Farmacia</a></li>
        </ul>
      </li>
  
      <!-- Otros Módulos -->
      <li class="nav-item">
        <a class="nav-link  " href="#"  id="ver-usuarios-link"  >
            <i class="bi bi-person-circle"></i> Usuarios
          </a>
      </li>
      <li class="nav-item">
        <a href="#configuracion" class="nav-link">
          <i class="bi bi-gear"></i> Configuración
        </a>
      </li>
  
      <li class="nav-item">
        <a href="#" id="logout-link" class="nav-link" >
          <i class="bi bi-box-arrow-right"></i> Salir
        </a>
      </li>
    </ul>
  </aside>
  

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <div class="logo">Sistema de Gestión</div>
      <div class="user-info">Bienvenido, Usuario</div>
    </div>
    
    <!-- Dashboard Section -->
    <div id="dashboard" class="card p-4">
      <h2>Dashboard</h2>
      <p>Bienvenido al panel principal, donde puedes gestionar todos los aspectos de tu clínica y farmacia.</p>
    </div>

    <!-- Agregar más secciones aquí -->
  </div>

  <script src="../../frontend/js/admin.js"> </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

