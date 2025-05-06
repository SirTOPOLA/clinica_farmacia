<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login – FarmaSalud</title>

    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/login.css">


</head>

<body>

<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-center p-0 login-wrapper">
  <!-- Card completa en móvil y solo form en escritorio -->
  <div class="login-card d-flex flex-column flex-md-row overflow-hidden">

    <!-- Imagen -->
    <div class="login-image d-block d-md-none"></div> <!-- visible solo en móviles -->
    <div class="col-md-6 d-none d-md-block p-0">
      <div class="login-image"></div>
    </div>

    <!-- Formulario -->
    <div class="col-md-6 p-4 d-flex align-items-center justify-content-center">
    <div class="login-form">
  <h3 class="mb-4 text-center text-success fw-semibold">Bienvenido a <span class="fw-bold">FarmaSalud</span></h3>
  <form action="./php/login.php" method="POST" novalidate>
    
    <div class="mb-4">
      <label for="correo" class="form-label fw-semibold">Usuario</label>
      <div class="input-group shadow-sm rounded">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-success"></i></span>
        <input type="email" id="usuario" name="correo" class="form-control border-start-0" placeholder="Ingrese su usuario" required aria-label="Usuario">
      </div>
    </div>

    <div class="mb-4">
      <label for="contrasena" class="form-label fw-semibold">Contraseña</label>
      <div class="input-group shadow-sm rounded">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-success"></i></span>
        <input type="password" id="clave" name="contrasena" class="form-control border-start-0" placeholder="Ingrese su contraseña" required aria-label="Contraseña">
      </div>
    </div>

    <div class="d-grid mb-3">
      <button type="submit" class="btn btn-login text-white shadow-sm">Ingresar</button>
    </div>

    <div class="text-center">
      
      <a href="registrar.php" class="registrar">registrar</a>
    </div>
  </form>
</div>

    </div>
  </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>