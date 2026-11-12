<?php
session_start();
require_once 'includes/db.php';

$errors = [];
$full_name = $username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';

    if ($full_name === '' || $username === '' || $email === '' || $password === '' || $confirm === '') {
        $errors[] = 'Please fill in all fields.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($username !== '' && !preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
        $errors[] = 'Username must be 3-20 characters: letters, numbers, underscore only.';
    }
    if ($password !== '' && strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'That username or email is already taken.';
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (full_name, username, email, password_hash) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $full_name, $username, $email, $hash);
        $stmt->execute();
        header('Location: index.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | SIA Multimedia</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-page">
  <div class="auth-card">
    <h1>Create Account</h1>
    <p class="subtitle">Join SIA Multimedia</p>

    <?php foreach ($errors as $err): ?>
      <div class="alert error"><?= e($err) ?></div>
    <?php endforeach; ?>

    <form method="POST" action="register.php">
      <label for="full_name">Full Name</label>
      <input type="text" id="full_name" name="full_name" value="<?= e($full_name) ?>">

      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?= e($username) ?>">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>">

      <label for="password">Password</label>
      <input type="password" id="password" name="password">

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password">

      <button type="submit" class="btn">Register</button>
    </form>
    <p class="switch">Already have an account? <a href="index.php">Log in</a></p>
  </div>
</body>
</html>
