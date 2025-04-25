<?php
if (isset($_SESSION['alerta']) && is_array($_SESSION['alerta'])) {
    $tipo = $_SESSION['alerta']['tipo'] ?? 'info'; // success, error, warning, info
    $mensaje = htmlspecialchars($_SESSION['alerta']['mensaje'] ?? '');
    $iconos = [
        'success' => 'bi-check-circle-fill',
        'error'   => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];
    $clases = [
        'success' => 'bg-success text-white border-success',
        'error'   => 'bg-danger text-white border-danger',
        'warning' => 'bg-warning text-dark border-warning',
        'info'    => 'bg-info text-white border-info',
    ];
    ?>
    <div id="alerta-global" class="alerta-flotante <?= $clases[$tipo] ?? $clases['info'] ?>">
        <i class="bi <?= $iconos[$tipo] ?? $iconos['info'] ?>"></i>
        <span><?= $mensaje ?></span>
        <button type="button" class="btn-cerrar" aria-label="Cerrar">&times;</button>
    </div>
    <?php
    unset($_SESSION['alerta']); // Se borra al mostrarse
}
?>
