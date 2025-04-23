<?php
// company_dashboard.php
require_once 'functions.php';
requireLogin();

$user = currentUser();
if ($user['role'] !== 'company') redirect('login.php');

include 'header.php';
?>

<div style="max-width: 900px; margin: 0 auto;">
  <div style="background: #f2f2f2; padding: 20px; border-radius: 6px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h1 style="margin-bottom: 10px;">Panel de Empresa</h1>
    <p><strong>Empresa:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <a href="post_job.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #2d7a3e; color: white; border-radius: 4px; text-decoration: none;">📌 Publicar Oferta</a>
  </div>

  <h2>Mis Ofertas</h2>

  <?php
  $stmt = $db->prepare(
    "SELECT j.*,
            (SELECT COUNT(*) FROM applications a WHERE a.job_id=j.id) AS applicants_count
     FROM jobs j WHERE company_id=?"
  );
  $stmt->execute([$user['id']]);
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?php if (empty($jobs)): ?>
    <p>No has publicado ninguna oferta aún.</p>
  <?php else: ?>
    <?php foreach ($jobs as $job): ?>
      <div class="job-card" style="width: 100%; border: 1px solid #ccc; padding: 20px; margin-bottom: 15px; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0;"><?= htmlspecialchars($job['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

        <?php if ($job['applicants_count'] > 0): ?>
          <p class="taken">
            Oferta tomada (<?= $job['applicants_count'] ?> aplicante<?= $job['applicants_count'] > 1 ? 's' : '' ?>)
            <a href="view_applicants.php?job_id=<?= $job['id'] ?>" style="margin-left: 10px; text-decoration: underline;">Ver Aplicantes</a>
          </p>
        <?php else: ?>
          <p class="open">Sin aplicantes aún</p>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

</body>
</html>
