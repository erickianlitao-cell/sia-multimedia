<?php
require_once '../includes/session_check.php';

$games = $conn->query('SELECT * FROM games ORDER BY id ASC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Games | SIA Multimedia</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">🎮 Games</div>
    <div class="links">
      <a href="../dashboard.php" class="btn btn-small btn-outline">Dashboard</a>
      <a href="../logout.php" class="btn btn-small btn-outline">Logout</a>
    </div>
  </header>

  <main class="container">
    <h1>Choose a Game</h1>
    <p class="subtitle">All games run right in your browser</p>

    <div class="grid">
      <?php while ($g = $games->fetch_assoc()): ?>
        <div class="card">
          <img src="<?= e(BASE_URL . '/' . $g['thumbnail']) ?>" alt="<?= e($g['title']) ?>">
          <div class="info">
            <h3><?= e($g['title']) ?></h3>
            <p><?= e($g['description']) ?></p>
            <a class="btn" href="<?= e(BASE_URL . '/' . $g['game_path']) ?>">▶ Play</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
