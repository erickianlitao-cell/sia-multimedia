<?php
require_once 'includes/session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | SIA Multimedia</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">🎬 SIA Multimedia</div>
    <a href="logout.php" class="btn btn-small btn-outline">Logout</a>
  </header>

  <main class="container">
    <h1>Welcome, <?= e($_SESSION['full_name']) ?>! 👋</h1>
    <p class="subtitle">What do you want to do today?</p>

    <div class="dash-buttons">
      <a href="videos/index.php" class="dash-btn">
        <span class="icon">🎥</span>
        <span class="label">Videos</span>
        <span class="hint">Discover new creators</span>
      </a>
      <a href="music/index.php" class="dash-btn">
        <span class="icon">🎵</span>
        <span class="label">Music</span>
        <span class="hint">Listen to new artists</span>
      </a>
      <a href="games/index.php" class="dash-btn">
        <span class="icon">🎮</span>
        <span class="label">Games</span>
        <span class="hint">Play 3 fun games</span>
      </a>
    </div>
  </main>
</body>
</html>
