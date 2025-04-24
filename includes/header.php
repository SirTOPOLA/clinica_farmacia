 

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Clínica y Farmacia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

 



  <!-- Sidebar -->
  <?php
     include_once("sidebar.php");
      ?>
   

  <!-- Navbar -->
  <nav class="navbar">
  <span class="navbar-brand mb-0 h1 text-white">Clínica y Farmacia</span>
  <div class="ms-auto text-white d-flex align-items-center gap-3">
    <span class="fw-bold"><?= $_SESSION['usuario'] ?? 'Usuario' ?></span>
    <span class="badge bg-light text-dark text-capitalize"><?= $_SESSION['rol'] ?? 'Sin rol' ?></span>
  </div>
</nav>