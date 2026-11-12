<?php
require_once '../includes/session_check.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare('SELECT * FROM videos WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$video = $stmt->get_result()->fetch_assoc();

if (!$video) {
    header('Location: index.php');
    exit;
}

$stmt2 = $conn->prepare('SELECT id, title, creator, thumbnail_url FROM videos WHERE id != ? ORDER BY RAND() LIMIT 4');
$stmt2->bind_param('i', $id);
$stmt2->execute();
$suggestions = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($video['title']) ?> | SIA Multimedia</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">🎥 Videos</div>
    <div class="links">
      <a href="../dashboard.php" class="btn btn-small btn-outline">Dashboard</a>
      <a href="../logout.php" class="btn btn-small btn-outline">Logout</a>
    </div>
  </header>

  <main class="container">
    <a class="back" href="index.php">&larr; Back to videos</a>

    <div class="watch">
      <section>
        <div class="player-wrap">
          <iframe src="<?= e($video['embed_url']) ?>" title="<?= e($video['title']) ?>"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        </div>
        <div class="video-details">
          <h1><?= e($video['title']) ?></h1>
          <p class="meta">By <?= e($video['creator']) ?> &bull; Source: <?= e($video['source_site']) ?></p>
          <p><?= e($video['description']) ?></p>
        </div>
      </section>

      <aside class="suggest">
        <h2 style="margin-bottom:12px">More videos</h2>
        <?php while ($s = $suggestions->fetch_assoc()): ?>
          <a class="card" href="watch.php?id=<?= (int)$s['id'] ?>">
            <img src="<?= e($s['thumbnail_url']) ?>" alt="">
            <div class="info">
              <h3><?= e($s['title']) ?></h3>
              <p><?= e($s['creator']) ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </aside>
    </div>
  </main>
</body>
</html>
