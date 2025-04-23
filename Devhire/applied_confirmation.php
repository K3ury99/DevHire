<?php
// applied_confirmation.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'functions.php';
requireLogin();

$user = currentUser();
if ($user['role'] !== 'candidate') redirect('login.php');

include 'header.php';  // Incluir el header con el estilo

// Verificar si hay un mensaje de éxito o error
if (isset($_SESSION['success'])): ?>
  <div class="flash success">
    <?= $_SESSION['success']; ?>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php elseif (isset($_SESSION['error'])): ?>
  <div class="flash error">
    <?= $_SESSION['error']; ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<h1>Confirmación de Aplicación</h1>

<div class="confirmation-message">
    <h2>¡Has aplicado exitosamente a la oferta!</h2>
    <p>Gracias por tu interés. Los reclutadores estarán en contacto contigo pronto.</p>
    <a href="jobs_list.php" class="btn">Volver a la Lista de Ofertas</a>
</div>

</body>
</html>
