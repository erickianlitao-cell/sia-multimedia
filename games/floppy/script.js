const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const scoreEl = document.getElementById('score');
const bestEl = document.getElementById('best');

const GRAVITY = 0.45;
const FLAP = -7.5;
const PIPE_SPEED = 2.4;
const PIPE_GAP = 140;
const PIPE_WIDTH = 56;
const PIPE_EVERY = 95;
const GROUND_H = 50;

let bird, pipes, score, frame, state;
let best = 0;
try { best = parseInt(localStorage.getItem('floppyBest')) || 0; } catch (e) {}
bestEl.textContent = best;

function reset() {
  bird = { x: 80, y: 220, r: 14, vy: 0 };
  pipes = [];
  score = 0;
  frame = 0;
  state = 'ready';
  scoreEl.textContent = 0;
}

function flap() {
  if (state === 'over') { reset(); return; }
  if (state === 'ready') state = 'playing';
  bird.vy = FLAP;
}

document.addEventListener('keydown', e => {
  if (e.code === 'Space') { e.preventDefault(); flap(); }
});
canvas.addEventListener('mousedown', flap);
canvas.addEventListener('touchstart', e => { e.preventDefault(); flap(); }, { passive: false });
document.getElementById('restartBtn').addEventListener('click', reset);

function gameOver() {
  state = 'over';
  if (score > best) {
    best = score;
    bestEl.textContent = best;
    try { localStorage.setItem('floppyBest', best); } catch (e) {}
  }
}

function update() {
  if (state !== 'playing') return;
  frame++;

  bird.vy += GRAVITY;
  bird.y += bird.vy;

  if (frame % PIPE_EVERY === 0) {
    const minTop = 60;
    const maxTop = canvas.height - GROUND_H - PIPE_GAP - 60;
    const top = minTop + Math.random() * (maxTop - minTop);
    pipes.push({ x: canvas.width, top: top, passed: false });
  }

  for (const p of pipes) {
    p.x -= PIPE_SPEED;

    if (!p.passed && p.x + PIPE_WIDTH < bird.x - bird.r) {
      p.passed = true;
      score++;
      scoreEl.textContent = score;
    }

    const hitX = bird.x + bird.r > p.x && bird.x - bird.r < p.x + PIPE_WIDTH;
    const hitTop = bird.y - bird.r < p.top;
    const hitBottom = bird.y + bird.r > p.top + PIPE_GAP;
    if (hitX && (hitTop || hitBottom)) gameOver();
  }

  pipes = pipes.filter(p => p.x + PIPE_WIDTH > 0);

  if (bird.y + bird.r > canvas.height - GROUND_H || bird.y - bird.r < 0) gameOver();
}

function draw() {
  ctx.fillStyle = '#70c5ce';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  ctx.fillStyle = '#2e9e3e';
  for (const p of pipes) {
    ctx.fillRect(p.x, 0, PIPE_WIDTH, p.top);
    ctx.fillRect(p.x, p.top + PIPE_GAP, PIPE_WIDTH, canvas.height);
  }

  ctx.fillStyle = '#ded895';
  ctx.fillRect(0, canvas.height - GROUND_H, canvas.width, GROUND_H);

  ctx.fillStyle = '#facc15';
  ctx.beginPath();
  ctx.arc(bird.x, bird.y, bird.r, 0, Math.PI * 2);
  ctx.fill();
  ctx.fillStyle = '#fff';
  ctx.beginPath(); ctx.arc(bird.x + 5, bird.y - 4, 4, 0, Math.PI * 2); ctx.fill();
  ctx.fillStyle = '#000';
  ctx.beginPath(); ctx.arc(bird.x + 6, bird.y - 4, 2, 0, Math.PI * 2); ctx.fill();
  ctx.fillStyle = '#f97316';
  ctx.fillRect(bird.x + 10, bird.y, 10, 5);

  ctx.fillStyle = '#fff';
  ctx.strokeStyle = '#000';
  ctx.lineWidth = 4;
  ctx.font = 'bold 40px Arial';
  ctx.textAlign = 'center';
  ctx.strokeText(score, canvas.width / 2, 70);
  ctx.fillText(score, canvas.width / 2, 70);

  ctx.font = 'bold 22px Arial';
  if (state === 'ready') {
    ctx.strokeText('Press Space / Tap to start', canvas.width / 2, 300);
    ctx.fillText('Press Space / Tap to start', canvas.width / 2, 300);
  }
  if (state === 'over') {
    ctx.strokeText('Game Over!', canvas.width / 2, 260);
    ctx.fillText('Game Over!', canvas.width / 2, 260);
    ctx.strokeText('Tap or Space to retry', canvas.width / 2, 295);
    ctx.fillText('Tap or Space to retry', canvas.width / 2, 295);
  }
}

function loop() {
  update();
  draw();
  requestAnimationFrame(loop);
}

reset();
loop();
