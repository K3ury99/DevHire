<?php
// functions.php
session_start(); // Asegúrate de que solo se inicie una vez

require_once __DIR__ . '/database.php';

function isLoggedIn() {
    return isset($_SESSION['user']);  // Verifica si el usuario está logueado
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');  // Redirige a login si no está logueado
        exit;
    }
}

function currentUser() {
    return $_SESSION['user'] ?? null;  // Devuelve el usuario actual si existe en sesión
}

function redirect($url) {
    header('Location: ' . $url);  // Redirige a la URL proporcionada
    exit;
}
?>
