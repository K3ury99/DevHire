<?php
// register.php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = $_POST['role'];
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact  = $_POST['contact'] ?? '';

    $stmt = $db->prepare("INSERT INTO users (role, name, email, password, contact) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$role, $name, $email, $password, $contact]);

    $_SESSION['success'] = 'Registro exitoso. Ya puedes iniciar sesión.';
    redirect('login.php');
}
?>
<?php include 'header.php'; ?>

<h2 style="margin-bottom: 20px;">Registro de Usuario</h2>

<form method="post" style="max-width: 500px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
  <label for="role">Tipo de Usuario:</label>
  <select name="role" id="role" required>
    <option value="candidate">Candidato</option>
    <option value="company">Empresa</option>
  </select>

  <label for="name">Nombre / Empresa:</label>
  <input type="text" name="name" id="name" required>

  <label for="email">Correo Electrónico:</label>
  <input type="email" name="email" id="email" required>

  <label for="password">Contraseña:</label>
  <input type="password" name="password" id="password" required>

  <label for="contact">Contacto:</label>
  <input type="text" name="contact" id="contact">

  <button type="submit" style="background-color: #2d7a3e; color: white; cursor: pointer;">Registrar</button>
</form>

</body>
</html>
