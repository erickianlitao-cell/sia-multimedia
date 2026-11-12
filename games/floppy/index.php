<?php
require_once '../../includes/session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Floppy Bird | SIA Multimedia</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">🐤 Floppy Bird</div>
    <a href="../index.php" class="btn btn-small btn-outline">Back to Games</a>
  </header>

  <main class="container game-box">
    <p class="subtitle">Press <b>Space</b>, click, or tap to flap. Avoid the pipes!</p>

    <div class="scoreboard">
      <div>Score<br><b id="score">0</b></div>
      <div>Best<br><b id="best">0</b></div>
    </div>

    <canvas id="game" width="360" height="520"></canvas>

    <div class="game-actions">
      <button class="btn" id="restartBtn">🔄 Restart</button>
      <a class="btn btn-outline" href="../index.php">Back</a>
    </div>
  </main>
  <script src="script.js"></script>
</body>
</html>
