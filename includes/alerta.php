<?php 

if (isset($_SESSION['mensaje']) && !empty($_SESSION['mensaje'])):
    ?>
    <div id="alerta-mensaje"
        class="alert alert-success alert-dismissible shadow-sm fade show d-flex align-items-start gap-2 p-3 mt-3 border border-success-subtle rounded-3"
        role="alert" style="animation: fadeIn 0.5s ease-in-out;">
        <i class="bi bi-check-circle-fill fs-4 flex-shrink-0 mt-1"></i>
        <div>
            <strong>¡Éxito!</strong>
            <p class="mb-0 mt-1"><?= htmlspecialchars($_SESSION['mensaje']) ?></p>
        </div>
        <button type="button" class="btn-close ms-auto mt-1" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>

    <script>
        // Ocultar automáticamente luego de 6 segundos
        setTimeout(() => {
            const alerta = document.getElementById('alerta-mensaje');
            if (alerta) {
                alerta.classList.remove('show');
                alerta.classList.add('fade');
                setTimeout(() => alerta.remove(), 500); // Lo remueve del DOM
            }
        }, 6000);
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <?php
    unset($_SESSION['mensaje']); // Limpiar mensaje de éxito de la sesión
endif;
?>