<?php
// jobs_list.php
require_once 'functions.php';
requireLogin();

$user = currentUser();
if ($user['role'] !== 'candidate') redirect('login.php');

// Mostrar las ofertas de trabajo
$stmt = $db->prepare("SELECT * FROM jobs");
$stmt->execute();
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar si hay mensajes de éxito o error
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

<h1>Lista de Ofertas</h1>

<?php
if (empty($jobs)) {
    echo "<p>No hay ofertas de trabajo disponibles en este momento.</p>";
} else {
    foreach ($jobs as $job) {
        echo "<div class='job-card'>";
        echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($job['description'])) . "</p>";
        echo "<a href='apply.php?job_id=" . $job['id'] . "' class='apply-button'>Aplicar</a>";
        echo "</div>";
    }
}
?>
