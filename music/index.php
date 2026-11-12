<?php
require_once '../includes/session_check.php';

$tracks = $conn->query('SELECT id, title, artist, cover_url FROM tracks ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Music | SIA Multimedia</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">🎵 Music</div>
    <div class="links">
      <a href="../dashboard.php" class="btn btn-small btn-outline">Dashboard</a>
      <a href="../logout.php" class="btn btn-small btn-outline">Logout</a>
    </div>
  </header>

  <main class="container">
    <h1>Discover New Artists</h1>
    <p class="subtitle">Pick a track to start listening</p>

    <div class="grid">
      <?php if ($tracks->num_rows === 0): ?>
        <p class="empty">No tracks yet.</p>
      <?php endif; ?>

      <?php while ($t = $tracks->fetch_assoc()): ?>
        <a class="card square" href="player.php?id=<?= (int)$t['id'] ?>">
          <img src="<?= e(preg_match('#^https?://#', $t['cover_url']) ? $t['cover_url'] : '../' . $t['cover_url']) ?>" alt="">
          <div class="info">
            <h3><?= e($t['title']) ?></h3>
            <p><?= e($t['artist']) ?></p>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
