const boardEl  = document.getElementById('board');
const statusEl = document.getElementById('status');

const WIN_LINES = [
  [0,1,2],[3,4,5],[6,7,8],
  [0,3,6],[1,4,7],[2,5,8],
  [0,4,8],[2,4,6]
];

let board = Array(9).fill('');
let gameOver = false;
let score = { you: 0, draw: 0, cpu: 0 };

const cells = [];
for (let i = 0; i < 9; i++) {
  const btn = document.createElement('button');
  btn.className = 'cell';
  btn.addEventListener('click', () => playerMove(i));
  boardEl.appendChild(btn);
  cells.push(btn);
}

function getWinner(b) {
  for (const line of WIN_LINES) {
    const [a, c, d] = line;
    if (b[a] && b[a] === b[c] && b[a] === b[d]) return line;
  }
  return null;
}

function draw() {
  cells.forEach((btn, i) => {
    btn.textContent = board[i] === 'X' ? '❌' : board[i] === 'O' ? '⭕' : '';
    btn.disabled = board[i] !== '' || gameOver;
  });
}

function checkEnd() {
  const line = getWinner(board);
  if (line) {
    gameOver = true;
    line.forEach(i => cells[i].classList.add('win'));
    if (board[line[0]] === 'X') {
      statusEl.textContent = '🎉 You win!';
      score.you++;
    } else {
      statusEl.textContent = '🤖 Computer wins!';
      score.cpu++;
    }
  } else if (!board.includes('')) {
    gameOver = true;
    statusEl.textContent = "It's a draw!";
    score.draw++;
  }
  document.getElementById('scoreYou').textContent  = score.you;
  document.getElementById('scoreDraw').textContent = score.draw;
  document.getElementById('scoreCpu').textContent  = score.cpu;
  return gameOver;
}

function playerMove(i) {
  if (gameOver || board[i] !== '') return;
  board[i] = 'X';
  draw();
  if (checkEnd()) { draw(); return; }
  statusEl.textContent = 'Computer is thinking...';
  setTimeout(computerMove, 450);
}

function findWinningSpot(mark) {
  for (const [a, b, c] of WIN_LINES) {
    const line = [board[a], board[b], board[c]];
    if (line.filter(x => x === mark).length === 2 && line.includes('')) {
      return [a, b, c][line.indexOf('')];
    }
  }
  return -1;
}

function computerMove() {
  let spot = findWinningSpot('O');
  if (spot === -1) spot = findWinningSpot('X');
  if (spot === -1 && board[4] === '') spot = 4;
  if (spot === -1) {
    const corners = [0,2,6,8].filter(i => board[i] === '');
    if (corners.length) spot = corners[Math.floor(Math.random() * corners.length)];
  }
  if (spot === -1) {
    const empty = board.map((v, i) => v === '' ? i : -1).filter(i => i !== -1);
    spot = empty[Math.floor(Math.random() * empty.length)];
  }
  board[spot] = 'O';
  if (!checkEnd()) statusEl.textContent = 'Your turn!';
  draw();
}

function restart() {
  board = Array(9).fill('');
  gameOver = false;
  cells.forEach(c => c.classList.remove('win'));
  statusEl.textContent = 'Your turn!';
  draw();
}
document.getElementById('restartBtn').addEventListener('click', restart);

draw();
