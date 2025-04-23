<?php
// post_job.php
require_once 'functions.php';
requireLogin();
$user = currentUser();
if ($user['role'] !== 'company') redirect('login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $req   = $_POST['requirements'];

    $stmt = $db->prepare(
      "INSERT INTO jobs (company_id,title,description,requirements) VALUES (?,?,?,?)"
    );
    $stmt->execute([$user['id'], $title, $desc, $req]);
    redirect('company_dashboard.php');
}
?>
<?php include 'header.php'; ?>

<h2 style="margin-bottom: 20px;">Publicar Nueva Oferta</h2>

<form method="post" style="max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <label for="title">Título del Puesto:</label>
  <input type="text" name="title" id="title" required>

  <label for="description">Descripción:</label>
  <textarea name="description" id="description" rows="5" required></textarea>

  <label for="requirements">Requisitos:</label>
  <textarea name="requirements" id="requirements" rows="4"></textarea>

  <button type="submit" style="background-color: #2d7a3e; color: white; cursor: pointer;">Publicar</button>
</form>

</body>
</html>
