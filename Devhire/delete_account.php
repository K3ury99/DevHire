<?php
// delete_account.php
require_once 'functions.php';
requireLogin();

$user = currentUser();

// Eliminar todas las aplicaciones del candidato (si existe)
if ($user['role'] === 'candidate') {
    $db->prepare("DELETE FROM applications WHERE candidate_id = ?")
       ->execute([$user['id']]);
}

// Eliminar todas las ofertas y sus aplicaciones de la empresa
if ($user['role'] === 'company') {
    // primero borrar aplicaciones a sus ofertas
    $db->prepare(
      "DELETE FROM applications WHERE job_id IN (
         SELECT id FROM jobs WHERE company_id = ?
       )"
    )->execute([$user['id']]);
    // luego borrar las propias ofertas
    $db->prepare("DELETE FROM jobs WHERE company_id = ?")
       ->execute([$user['id']]);
}

// Finalmente, borrar el usuario (cvs y demás caerán en cascade)
$db->prepare("DELETE FROM users WHERE id = ?")
   ->execute([$user['id']]);

// Cerrar sesión y redirigir
session_start();
session_destroy();
header('Location: register.php');
exit;
