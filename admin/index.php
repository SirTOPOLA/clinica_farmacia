<?php
include_once("../includes/header.php");
$_SESSION['usuario'] = 'Dr. Santiago Obiang'; 
$rol = $_SESSION['rol'] ?? 'medico';
?>

<!-- Main Content -->
<div class="main-content  py-4">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-dark shadow rounded px-4 mb-4">
    <span class="navbar-brand mb-0 h1 text-white"><i class="bi bi-hospital-fill me-2"></i>Clínica y Farmacia</span>
    <div class="ms-auto text-white d-flex align-items-center gap-3">
      <span class="fw-semibold"><i class="bi bi-person-circle me-1"></i><?= $_SESSION['usuario'] ?? 'Usuario' ?></span>
      <span class="badge bg-light text-dark text-capitalize"><i class="bi bi-shield-lock-fill me-1"></i><?= $rol ?></span>
    </div>
  </nav>

  <!-- Dashboard Cards -->
  <div class="row g-4">
    <?php if (in_array($rol, ['reseccion', 'administrador'])): ?>
      <div class="col-md-4">
        <div class="card bg-primary text-white shadow-lg border-0 rounded-4 h-100 hover-shadow">
          <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-people-fill display-5 me-3"></i>
              <h5 class="card-title mb-0">Pacientes Registrados</h5>
            </div>
            <p class="card-text display-6 fw-bold text-end">128</p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if (in_array($rol, ['medico', 'administrador'])): ?>
      <div class="col-md-4">
        <div class="card bg-success text-white shadow-lg border-0 rounded-4 h-100 hover-shadow">
          <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-calendar-check-fill display-5 me-3"></i>
              <h5 class="card-title mb-0">Citas de Hoy</h5>
            </div>
            <p class="card-text display-6 fw-bold text-end">32</p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($rol === 'laboratorio' || $rol === 'administrador'): ?>
      <div class="col-md-4">
        <div class="card bg-danger text-white shadow-lg border-0 rounded-4 h-100 hover-shadow">
          <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-flask display-5 me-3"></i>
              <h5 class="card-title mb-0">Pendientes en Laboratorio</h5>
            </div>
            <p class="card-text display-6 fw-bold text-end">12</p>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
  .hover-shadow:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 0.75rem 1.25rem rgba(0,0,0,0.15);
  }
</style>
</body>
</html>
