<?php include_once("../includes/header.php");?>
<?php include_once("../includes/sidebar.php");?>
      <!-- Main -->
      <main class="main-content">
        <div class="row g-4">
          <?php if (in_array($rol, ['reseccion', 'administrador'])): ?>
            <div class="col-md-4">
              <div class="card bg-primary text-white border-0 rounded-4 h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-people-fill display-5 me-3"></i>
                    <h5 class="mb-0">Pacientes Registrados</h5>
                  </div>
                  <p class="display-6 fw-bold text-end">128</p>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <?php if (in_array($rol, ['medico', 'administrador'])): ?>
            <div class="col-md-4">
              <div class="card bg-success text-white border-0 rounded-4 h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-calendar-check-fill display-5 me-3"></i>
                    <h5 class="mb-0">Citas de Hoy</h5>
                  </div>
                  <p class="display-6 fw-bold text-end">32</p>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <?php if (in_array($rol, ['laboratorio', 'administrador'])): ?>
            <div class="col-md-4">
              <div class="card bg-danger text-white border-0 rounded-4 h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-flask display-5 me-3"></i>
                    <h5 class="mb-0">Pendientes en Laboratorio</h5>
                  </div>
                  <p class="display-6 fw-bold text-end">12</p>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </main>

  <?php include_once("../includes/footer.php");?>