<?php
// view_applicants.php
require_once 'functions.php';
requireLogin();

$user = currentUser();
if ($user['role'] !== 'company') redirect('login.php');

$job_id = (int)($_GET['job_id'] ?? 0);

// Obtener la información de la oferta
$stmt = $db->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->execute([$job_id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    $_SESSION['error'] = 'Oferta no encontrada.';
    redirect('company_dashboard.php');
}

// Obtener los candidatos que han aplicado
$stmt = $db->prepare(
    "SELECT u.name, u.email
     FROM users u
     JOIN applications a ON a.candidate_id = u.id
     WHERE a.job_id = ?"
);
$stmt->execute([$job_id]);
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Estilo de la página -->
<div style="max-width: 900px; margin: 0 auto;">
  <div style="background: #f2f2f2; padding: 20px; border-radius: 6px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h1 style="margin-bottom: 10px;">Aplicantes a la oferta: <?= htmlspecialchars($job['title']) ?></h1>
    <a href="company_dashboard.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #2d7a3e; color: white; border-radius: 4px; text-decoration: none;">← Volver al Panel de Empresa</a>
  </div>

  <?php if (empty($applicants)): ?>
    <p>No hay aplicantes para esta oferta.</p>
  <?php else: ?>
    <h3>Lista de aplicantes:</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <thead>
        <tr>
          <th style="border: 1px solid #ccc; padding: 10px;">Nombre</th>
          <th style="border: 1px solid #ccc; padding: 10px;">Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($applicants as $applicant): ?>
          <tr>
            <td style="border: 1px solid #ccc; padding: 10px;"><?= htmlspecialchars($applicant['name']) ?></td>
            <td style="border: 1px solid #ccc; padding: 10px;"><?= htmlspecialchars($applicant['email']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

</body>
</html>
