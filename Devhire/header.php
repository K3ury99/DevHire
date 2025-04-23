<?php
// header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegúrate de que session_start solo se ejecute una vez
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevHire - Plataforma de Empleos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <ul>
            <li><a href="company_dashboard.php">Dashboard</a></li>
            <li><a href="view_jobs.php">Ver Ofertas</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </div>
    <div class="container">
        <!-- Aquí estará el contenido principal de la página -->
