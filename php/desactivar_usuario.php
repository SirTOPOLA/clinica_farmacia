<?php
include '../config/conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que el id_usuario está presente
    if (isset($_POST['id_usuario'])) {
        $id_usuario = $_POST['id_usuario'];
        
        // Actualizar el estado del usuario a inactivo (0)
        $sql = "UPDATE usuarios SET activo = 0 WHERE id_usuario = ?";
        
        // Ejecutar la consulta
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->execute([$id_usuario]);
            $_SESSION['mensaje'] = 'Usuario desactivado correctamente';
            header('Location: ../admin/listar_usuario.php');
            exit;
        }
    }
}
?>
