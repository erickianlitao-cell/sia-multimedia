<?php
require_once '../includes/session_check.php';

$q    = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'newest';

$order = ($sort === 'oldest') ? 'id ASC' : 'id DESC';

$like = '%' . $q . '%';
$stmt = $conn->prepare("SELECT id, title, creator, thumbnail_url FROM videos
                        WHERE title LIKE ? OR creator LIKE ? ORDER BY $order");
$stmt->bind_param('ss', $like, $like);
$stmt->execute();
$videos = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Videos | SIA Multimedia</title>
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
    <h1>Discover New Videos</h1>
    <p class="subtitle">Fresh and lesser-known creators</p>

    <form class="toolbar" method="GET" action="index.php">
      <input type="search" name="q" placeholder="Search title or creator..." value="<?= e($q) ?>">
      <select name="sort">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Oldest</option>
      </select>
      <button type="submit">Search</button>
    </form>

    <div class="grid">
      <?php if ($videos->num_rows === 0): ?>
        <p class="empty">No videos found.</p>
      <?php endif; ?>

      <?php while ($v = $videos->fetch_assoc()): ?>
        <a class="card" href="watch.php?id=<?= (int)$v['id'] ?>">
          <img src="<?= e($v['thumbnail_url']) ?>" alt="<?= e($v['title']) ?>">
          <div class="info">
            <h3><?= e($v['title']) ?></h3>
            <p><?= e($v['creator']) ?></p>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
