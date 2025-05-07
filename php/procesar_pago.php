<?php
include '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_resultado = $_POST['id_resultado'] ?? null;
    $monto = $_POST['monto'] ?? null;

    if ($id_resultado && $monto) {
        $sql = "UPDATE laboratorio SET pagado = 1 WHERE id_resultado = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id_resultado]);

        $_SESSION['mensaje'] = 'Pago registrado correctamente.';
        $_SESSION['tipo_mensaje'] = 'success';
    } else {
        $_SESSION['mensaje'] = 'Error al registrar el pago.';
        $_SESSION['tipo_mensaje'] = 'danger';
    }
    header("Location: ../admin/laboratorio.php");
    exit;
}
?>
