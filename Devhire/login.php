<?php
// login.php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass  = $_POST['password'];
    $stmt  = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user  = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user'] = $user;
        if ($user['role'] === 'candidate') {
            redirect('candidate_dashboard.php');
        } else {
            redirect('company_dashboard.php');
        }
    } else {
        $error = 'Credenciales inválidas';
    }
}
?>
<?php include 'header.php'; ?>

<h2>Login</h2>
<form method="post">
  <label>Email:</label>
  <input type="email" name="email" required>
  <label>Contraseña:</label>
  <input type="password" name="password" required>
  <button type="submit">Ingresar</button>
</form>

<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a> como Candidato o Empresa.</p>

<?php if (isset($error)): ?>
  <div class="flash error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

</body>
</html>
