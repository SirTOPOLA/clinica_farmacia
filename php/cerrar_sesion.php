<?php
// Iniciar la sesión
session_start();

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login
header("Location: ../index.php"); // Cambia esto por la ruta de tu página de login
exit();
?>
