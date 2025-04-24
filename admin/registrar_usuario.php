<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
<!-- Main Content -->
<div class="main-content container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Usuario</h5>
            <a href="listar_usuarios.php" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver a la lista
            </a>
        </div>

        <div class="card-body">
            <form action="../php/insertar_usuarios.php" method="POST" class="needs-validation" novalidate>
                <div class="row g-4">
                    <!-- Código de Empleado -->
                    <div class="col-md-6">
                        <label for="codigo_empleado" class="form-label">Código de Empleado</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                            <input type="text" class="form-control" id="codigo_empleado" name="codigo_empleado" required>
                            <div class="invalid-feedback">Campo obligatorio.</div>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                            <div class="invalid-feedback">Ingrese un correo válido.</div>
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="col-md-6">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="6" required>
                            <div class="invalid-feedback">La contraseña debe tener al menos 6 caracteres.</div>
                        </div>
                    </div>

                    <!-- Rol -->
                    <div class="col-md-6">
                        <label for="id_rol" class="form-label">Rol de Usuario</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-person-gear"></i></span>
                            <select class="form-select" id="id_rol" name="id_rol" required>
                                <option value="" selected disabled>Seleccione un rol</option>
                                <option value="1">ADMINISTRADOR</option>
                                <option value="2">RECEPCIÓN</option>
                                <option value="3">ENFERMERÍA</option>
                                <option value="4">LABORATORIO</option>
                                <option value="5">MÉDICO</option>
                            </select>
                            <div class="invalid-feedback">Debe seleccionar un rol.</div>
                        </div>
                    </div>

                    <!-- Usuario Activo -->
                    <div class="col-12 form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                        <label class="form-check-label" for="activo">
                            <i class="bi bi-check-circle me-1"></i>Usuario Activo
                        </label>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Registrar Usuario
                    </button>
                    <a href="listar_usuarios.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Validación Bootstrap
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', e => {
                if (!form.checkValidity()) {
                    e.preventDefault()
                    e.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
