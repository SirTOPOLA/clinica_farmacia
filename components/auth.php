<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    http_response_code(401); // No autorizado
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado']);
    exit;
}