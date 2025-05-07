<?php
if (isset($_GET['archivo'])) {
    $archivo = basename($_GET['archivo']); // Seguridad
    $ruta = __DIR__ . '/' . $archivo;

    if (file_exists($ruta)) {
        unlink($ruta);
        echo "Archivo eliminado: $archivo";
    } else {
        echo "Archivo no encontrado.";
    }
} else {
    echo "No se especificó archivo.";
}
