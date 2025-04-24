<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión Clínica + Farmacia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .hero {
      background: url('img/clinica-bg.jpg') no-repeat center center;
      background-size: cover;
      color: white;
      padding: 120px 0;
      text-align: center;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }
    .features .icon {
      font-size: 2rem;
      color: #0d6efd;
    }
    footer {
      background-color: #f8f9fa;
      padding: 40px 0;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">ClinicaPro</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Servicios</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
          <li class="nav-item"><a class="btn btn-primary ms-3" href="#">Iniciar sesión</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero d-flex align-items-center">
    <div class="container">
      <h1>Gestión inteligente para clínicas y farmacias</h1>
      <p class="lead mt-3">Organiza pacientes, stock y citas desde una sola plataforma.</p>
      <a href="#" class="btn btn-light btn-lg mt-4">Empezar ahora</a>
    </div>
  </section>

  <!-- Features -->
  <section class="features py-5" id="features">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">¿Qué ofrece nuestro sistema?</h2>
        <p class="text-muted">Soluciones completas para la gestión médica y farmacéutica</p>
      </div>
      <div class="row g-4">
        <div class="col-md-3 text-center">
          <div class="icon mb-2"><i class="bi bi-person-lines-fill"></i></div>
          <h5>Gestión de pacientes</h5>
          <p>Registra, consulta y edita historiales médicos fácilmente.</p>
        </div>
        <div class="col-md-3 text-center">
          <div class="icon mb-2"><i class="bi bi-capsule-pill"></i></div>
          <h5>Inventario de medicamentos</h5>
          <p>Control de stock, vencimientos y alertas inteligentes.</p>
        </div>
        <div class="col-md-3 text-center">
          <div class="icon mb-2"><i class="bi bi-calendar-check"></i></div>
          <h5>Citas médicas</h5>
          <p>Agenda y recordatorios automáticos para pacientes.</p>
        </div>
        <div class="col-md-3 text-center">
          <div class="icon mb-2"><i class="bi bi-receipt"></i></div>
          <h5>Facturación</h5>
          <p>Generación rápida de facturas y reportes financieros.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container text-center">
      <p class="mb-0">&copy; 2025 ClinicaPro. Todos los derechos reservados.</p>
      <small class="text-muted">Diseñado por Jesús Crispín TOPOLÁ BOÑAHO</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
