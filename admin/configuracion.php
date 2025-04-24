<?php 
include_once("../includes/header.php");
?>
  <!-- Main Content -->
  <div class="main-content">
    
<!-- Configuración del Sistema -->
<div id="configuracion-sistema" class="card p-4 mt-4">
  <h4 class="mb-4"><i class="bi bi-gear-fill me-2"></i> Configuración del Sistema</h4>
  <form>
    <div class="mb-3">
      <label for="nombreSistema" class="form-label">Nombre del Sistema</label>
      <input type="text" class="form-control" id="nombreSistema" placeholder="Ej: Clínica y Farmacia Central">
    </div>

    <div class="mb-3">
      <label for="emailSistema" class="form-label">Correo de contacto</label>
      <input type="email" class="form-control" id="emailSistema" placeholder="Ej: soporte@clinica.com">
    </div>

    <div class="mb-3">
      <label for="telefonoSoporte" class="form-label">Teléfono de Soporte</label>
      <input type="text" class="form-control" id="telefonoSoporte" placeholder="Ej: +240 555 123456">
    </div>

    <div class="mb-3">
      <label for="direccionSistema" class="form-label">Dirección</label>
      <input type="text" class="form-control" id="direccionSistema" placeholder="Ej: Calle Principal, Malabo, G.E.">
    </div>

    <div class="mb-3">
      <label for="tema" class="form-label">Tema del sistema</label>
      <select class="form-select" id="tema">
        <option value="claro">Claro</option>
        <option value="oscuro">Oscuro</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">
      <i class="bi bi-save2 me-1"></i> Guardar Configuración
    </button>
  </form>
</div>
 
 
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
