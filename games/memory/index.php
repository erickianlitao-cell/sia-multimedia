<?php
require_once '../../includes/session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Memory Match | SIA Multimedia</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">🃏 Memory Match</div>
    <a href="../index.php" class="btn btn-small btn-outline">Back to Games</a>
  </header>

  <main class="container game-box">
    <p class="subtitle">Flip two cards. Find all the matching pairs!</p>

    <div class="scoreboard">
      <div>Moves<br><b id="moves">0</b></div>
      <div>Matches<br><b id="matches">0 / 8</b></div>
      <div>Time<br><b id="time">0s</b></div>
    </div>

    <div class="status" id="status"></div>
    <div class="memory-board" id="board"></div>

    <div class="game-actions">
      <button class="btn" id="restartBtn">🔄 Restart</button>
      <a class="btn btn-outline" href="../index.php">Back</a>
    </div>
  </main>
  <script src="script.js"></script>
</body>
</html>
