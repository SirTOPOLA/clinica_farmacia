<?php
include_once("../includes/header.php");
include_once("../includes/sidebar.php");



$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>ID no proporcionado.</div>";
    exit;
}

// Obtener datos del resultado de laboratorio
$stmt = $conexion->prepare("SELECT l.*, 
                              p.nombre AS nombre_paciente, 
                              pm.nombre AS nombre_prueba 
                       FROM laboratorio l
                       JOIN pacientes p ON l.id_paciente = p.id_paciente
                       JOIN pruebas_medicas pm ON l.tipo_prueba = pm.id_prueba
                       WHERE l.id_resultado = ?");
$stmt->execute([$id]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$datos) {
    echo "<div class='alert alert-danger'>Resultado no encontrado.</div>";
    exit;
}
?>

<div class="main-content container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-info text-white rounded-top-4">
            <h5 class="mb-0"><i class="bi bi-flask me-2"></i> Editar Resultado de Laboratorio</h5>
        </div>

        <div class="card-body">
            <form class="needs-validation" action="../php/actualizar_resultado.php" method="POST" novalidate>
                <!-- ID oculto -->
                <input type="hidden" name="id_resultado" value="<?= htmlspecialchars($datos['id_resultado']) ?>">

                <div class="mb-3">
                    <label class="form-label">Paciente</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($datos['nombre_paciente']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" value="<?= htmlspecialchars($datos['fecha']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de Estudio</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($datos['nombre_prueba']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="resultado" class="form-label">Resultado</label>
                    
                    <input type="text" class="form-control" id="resultado"  name="resultado"  required>
                    <div class="invalid-feedback">Debe proporcionar el resultado del estudio.</div>
                </div>

               

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-pencil-square me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>


</body>

</html>