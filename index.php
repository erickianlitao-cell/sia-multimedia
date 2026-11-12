<?php
session_start();
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = isset($_GET['registered']) ? 'Account created! You can now log in.' : '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please fill in both username and password.';
    } else {
        $stmt = $conn->prepare('SELECT id, full_name, password_hash FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Wrong username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | SIA Multimedia</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
  <div class="auth-card">
    <h1>🎬 SIA Multimedia</h1>
    <p class="subtitle">Log in to discover new videos, music and games</p>

    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert success"><?= e($success) ?></div><?php endif; ?>

    <form method="POST" action="index.php">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?= e($username) ?>" autofocus>

      <label for="password">Password</label>
      <input type="password" id="password" name="password">

      <button type="submit" class="btn">Log In</button>
    </form>
    <p class="switch">No account yet? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
