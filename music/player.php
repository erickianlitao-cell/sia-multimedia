<?php
require_once '../includes/session_check.php';

$selectedId = (int)($_GET['id'] ?? 0);

$result = $conn->query('SELECT id, title, artist, audio_url, cover_url FROM tracks ORDER BY id DESC');
$tracks = [];
$startIndex = 0;
while ($row = $result->fetch_assoc()) {
    if (!preg_match('#^https?://#', $row['cover_url'])) {
        $row['cover_url'] = '../' . $row['cover_url'];
    }
    if ((int)$row['id'] === $selectedId) {
        $startIndex = count($tracks);
    }
    $tracks[] = $row;
}
if (count($tracks) === 0) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Music Player | SIA Multimedia</title>
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
    <a class="back" href="index.php">&larr; Back to tracks</a>

    <div class="music-layout">
      <section class="now-playing">
        <img id="cover" src="" alt="Cover">
        <h2 id="title">Title</h2>
        <p class="artist" id="artist">Artist</p>

        <div class="progress-row">
          <span id="current">0:00</span>
          <input type="range" id="progress" min="0" max="100" value="0">
          <span id="duration">0:00</span>
        </div>

        <div class="controls">
          <button id="prevBtn" title="Previous">⏮</button>
          <button id="playBtn" title="Play / Pause">▶</button>
          <button id="nextBtn" title="Next">⏭</button>
        </div>

        <div class="volume-row">
          🔊 <input type="range" id="volume" min="0" max="1" step="0.01" value="0.8">
        </div>

        <audio id="audio" preload="metadata"></audio>
      </section>

      <section class="playlist" id="playlist"></section>
    </div>
  </main>

  <script>
    const TRACKS = <?= json_encode($tracks, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>;
    const START_INDEX = <?= (int)$startIndex ?>;
  </script>
  <script src="../js/player.js"></script>
</body>
</html>
