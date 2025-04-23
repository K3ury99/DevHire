<?php
// candidate_dashboard.php
require_once 'functions.php';
requireLogin();

$user = currentUser();
if ($user['role'] !== 'candidate') redirect('login.php');

include 'header.php';
?>

<h1>Bienvenido, <?= htmlspecialchars($user['name']) ?></h1>

<a href="cv_form.php" class="cv-link">Completar CV</a>

<h2>Ofertas Disponibles</h2>

<?php
$stmt = $db->query("SELECT * FROM jobs ORDER BY created_at DESC");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($jobs)): ?>
  <p>No hay ofertas disponibles.</p>
<?php else: ?>
  <?php foreach ($jobs as $job): ?>
    <div class="job-card">
      <h3><?= htmlspecialchars($job['title']) ?></h3>
      <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
      <a href="apply.php?job_id=<?= $job['id'] ?>" class="apply-button">Aplicar</a>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
