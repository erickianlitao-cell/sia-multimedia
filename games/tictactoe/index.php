<?php
require_once '../../includes/session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tic-Tac-Toe | SIA Multimedia</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="topbar">
    <div class="brand">❌⭕ Tic-Tac-Toe</div>
    <a href="../index.php" class="btn btn-small btn-outline">Back to Games</a>
  </header>

  <main class="container game-box">
    <p class="subtitle">You are ❌ &mdash; the computer is ⭕</p>

    <div class="scoreboard">
      <div>You<br><b id="scoreYou">0</b></div>
      <div>Draws<br><b id="scoreDraw">0</b></div>
      <div>Computer<br><b id="scoreCpu">0</b></div>
    </div>

    <div class="status" id="status">Your turn!</div>
    <div class="board" id="board"></div>

    <div class="game-actions">
      <button class="btn" id="restartBtn">🔄 Restart</button>
      <a class="btn btn-outline" href="../index.php">Back</a>
    </div>
  </main>
  <script src="script.js"></script>
</body>
</html>
