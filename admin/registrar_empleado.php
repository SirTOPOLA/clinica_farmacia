<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");
?>
<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">
        <?php include_once("../includes/alerta.php"); ?>
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i> Registrar Nuevo Empleado</h5>
                <a href="listar_empleado.php" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Volver a la lista
                </a>
            </div>

            <div class="card-body">
                <form action="../php/insertar_empleados.php" method="POST" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">Campo obligatorio.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                                <div class="invalid-feedback">Campo obligatorio.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                                <div class="invalid-feedback">Ingrese un correo válido.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                <div class="invalid-feedback">Ingrese un número de teléfono válido.</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                                <div class="invalid-feedback">Campo obligatorio.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Registrar Empleado
                        </button>
                        <a href="listar_empleado.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
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