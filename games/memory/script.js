const boardEl  = document.getElementById('board');
const movesEl  = document.getElementById('moves');
const matchEl  = document.getElementById('matches');
const timeEl   = document.getElementById('time');
const statusEl = document.getElementById('status');

const EMOJIS = ['🐶','🐱','🦊','🐼','🐸','🦁','🐵','🐰'];

let cards = [];
let firstCard = null;
let lock = false;
let moves = 0;
let matches = 0;
let seconds = 0;
let timer = null;

function shuffle(arr) {
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
  return arr;
}

function startTimer() {
  if (timer) return;
  timer = setInterval(() => {
    seconds++;
    timeEl.textContent = seconds + 's';
  }, 1000);
}

function newGame() {
  clearInterval(timer);
  timer = null;
  firstCard = null;
  lock = false;
  moves = 0; matches = 0; seconds = 0;
  movesEl.textContent = '0';
  matchEl.textContent = '0 / 8';
  timeEl.textContent = '0s';
  statusEl.textContent = '';
  boardEl.innerHTML = '';

  cards = shuffle([...EMOJIS, ...EMOJIS]);

  cards.forEach(emoji => {
    const btn = document.createElement('button');
    btn.className = 'mcard';
    btn.dataset.emoji = emoji;
    btn.textContent = emoji;
    btn.addEventListener('click', () => flip(btn));
    boardEl.appendChild(btn);
  });
}

function flip(card) {
  if (lock || card.classList.contains('flipped') || card.classList.contains('matched')) return;

  startTimer();
  card.classList.add('flipped');

  if (!firstCard) {
    firstCard = card;
    return;
  }

  moves++;
  movesEl.textContent = moves;

  if (firstCard.dataset.emoji === card.dataset.emoji) {
    firstCard.classList.add('matched');
    card.classList.add('matched');
    matches++;
    matchEl.textContent = matches + ' / 8';
    firstCard = null;

    if (matches === EMOJIS.length) {
      clearInterval(timer);
      statusEl.textContent = '🎉 You won in ' + moves + ' moves and ' + seconds + ' seconds!';
    }
  } else {
    lock = true;
    const a = firstCard, b = card;
    firstCard = null;
    setTimeout(() => {
      a.classList.remove('flipped');
      b.classList.remove('flipped');
      lock = false;
    }, 800);
  }
}

document.getElementById('restartBtn').addEventListener('click', newGame);
newGame();
