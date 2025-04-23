<?php
// cv_form.php
require_once 'functions.php';
requireLogin();

$user = currentUser();
if ($user['role'] !== 'candidate') {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lista de campos del CV (14 campos)
    $fields = [
        'first_name', 'last_name', 'phone', 'address', 'city',
        'education', 'experience', 'skills', 'languages', 'objective',
        'achievements', 'availability', 'linkedin', 'reference_contacts'
    ];

    // Recoger valores de POST
    $values = [];
    foreach ($fields as $f) {
        $values[] = $_POST[$f] ?? '';
    }

    // Procesar subida de foto
    $photo = null;
    if (!empty($_FILES['photo']['name'])) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    // Procesar subida de PDF
    $pdf = null;
    if (!empty($_FILES['pdf']['name'])) {
        $pdf = 'uploads/' . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf);
    }

    // Construir placeholders: 14 para campos + 2 para photo/pdf = 16,
    // más 1 para user_id = 17 en total
    $placeholders = implode(',', array_fill(0, count($fields), '?'));

    // Generar SQL con 17 columnas y 17 signos de interrogación
    $sql = "
      INSERT OR REPLACE INTO cvs (
        user_id, " . implode(',', $fields) . ", photo_path, pdf_path
      ) VALUES (
        ?, {$placeholders}, ?, ?
      )
    ";
    $stmt = $db->prepare($sql);

    // Parámetros: [ user_id ] + 14 valores de $values + [ photo, pdf ]
    $params = array_merge(
        [ $user['id'] ],
        $values,
        [ $photo, $pdf ]
    );

    // Ejecutar
    $stmt->execute($params);

    redirect('candidate_dashboard.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Completar CV</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form method="post" enctype="multipart/form-data">
  <?php foreach ([
    'first_name'=>'Nombre','last_name'=>'Apellido','phone'=>'Teléfono','address'=>'Dirección',
    'city'=>'Ciudad','education'=>'Formación Acad.','experience'=>'Experiencia',
    'skills'=>'Habilidades','languages'=>'Idiomas','objective'=>'Objetivo',
    'achievements'=>'Logros','availability'=>'Disponibilidad',
    'linkedin'=>'LinkedIn','reference_contacts'=>'Referencias'
  ] as $field=>$label): ?>
    <label><?= $label ?>:</label>
    <input name="<?= $field ?>" required><br>
  <?php endforeach; ?>
  <label>Foto (opcional):</label><input type="file" name="photo"><br>
  <label>PDF CV (opcional):</label><input type="file" name="pdf"><br>
  <button type="submit">Guardar CV</button>
</form>
</body>
</html>
