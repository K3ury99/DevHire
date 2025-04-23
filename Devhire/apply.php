<?php
// apply.php
require_once 'functions.php';
session_start();
requireLogin();

$user = currentUser();
if ($user['role'] !== 'candidate') redirect('login.php');

$job_id = (int)($_GET['job_id'] ?? 0);

// Verificar si ya aplicó
$stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE job_id=? AND candidate_id=?");
$stmt->execute([$job_id, $user['id']]);
if ($stmt->fetchColumn() > 0) {
    $_SESSION['error'] = 'Ya aplicaste a esta oferta.';
    redirect('applied_confirmation.php'); // Redirigir a la página de confirmación si ya aplicó
}

// Insertar aplicación
$stmt = $db->prepare("INSERT INTO applications (job_id, candidate_id) VALUES (?, ?)");
$stmt->execute([$job_id, $user['id']]);

// Verificar si la inserción fue exitosa
if ($stmt->rowCount() > 0) {
    $_SESSION['success'] = 'Aplicación enviada correctamente.';
} else {
    $_SESSION['error'] = 'Hubo un problema al aplicar a esta oferta. Inténtalo nuevamente.';
}

// Redirigir a la página de confirmación
redirect('applied_confirmation.php');
?>
