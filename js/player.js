const audio    = document.getElementById('audio');
const playBtn  = document.getElementById('playBtn');
const prevBtn  = document.getElementById('prevBtn');
const nextBtn  = document.getElementById('nextBtn');
const progress = document.getElementById('progress');
const volume   = document.getElementById('volume');
const current  = document.getElementById('current');
const duration = document.getElementById('duration');
const coverEl  = document.getElementById('cover');
const titleEl  = document.getElementById('title');
const artistEl = document.getElementById('artist');
const playlist = document.getElementById('playlist');

let index = START_INDEX;

function formatTime(sec) {
  if (isNaN(sec)) return '0:00';
  const m = Math.floor(sec / 60);
  const s = Math.floor(sec % 60);
  return m + ':' + (s < 10 ? '0' : '') + s;
}

function buildPlaylist() {
  playlist.innerHTML = '';
  TRACKS.forEach((t, i) => {
    const row = document.createElement('div');
    row.className = 'track' + (i === index ? ' active' : '');

    const img = document.createElement('img');
    img.src = t.cover_url;

    const text = document.createElement('div');
    const title = document.createElement('div');
    title.className = 't-title';
    title.textContent = t.title;
    const artist = document.createElement('div');
    artist.className = 't-artist';
    artist.textContent = t.artist;
    text.append(title, artist);

    row.append(img, text);
    row.addEventListener('click', () => loadTrack(i, true));
    playlist.appendChild(row);
  });
}

function loadTrack(i, autoPlay) {
  index = i;
  const t = TRACKS[index];
  audio.src = t.audio_url;
  coverEl.src = t.cover_url;
  titleEl.textContent = t.title;
  artistEl.textContent = t.artist;
  progress.value = 0;
  current.textContent = '0:00';
  duration.textContent = '0:00';
  buildPlaylist();
  if (autoPlay) playAudio();
  else playBtn.textContent = '▶';
}

function playAudio() {
  audio.play().then(() => {
    playBtn.textContent = '⏸';
  }).catch(() => {
    playBtn.textContent = '▶';
  });
}

function togglePlay() {
  if (audio.paused) playAudio();
  else { audio.pause(); playBtn.textContent = '▶'; }
}

function nextTrack() {
  loadTrack((index + 1) % TRACKS.length, true);
}
function prevTrack() {
  loadTrack((index - 1 + TRACKS.length) % TRACKS.length, true);
}

playBtn.addEventListener('click', togglePlay);
nextBtn.addEventListener('click', nextTrack);
prevBtn.addEventListener('click', prevTrack);

audio.addEventListener('ended', nextTrack);

audio.addEventListener('loadedmetadata', () => {
  duration.textContent = formatTime(audio.duration);
});

audio.addEventListener('timeupdate', () => {
  if (audio.duration) {
    progress.value = (audio.currentTime / audio.duration) * 100;
    current.textContent = formatTime(audio.currentTime);
  }
});

progress.addEventListener('input', () => {
  if (audio.duration) audio.currentTime = (progress.value / 100) * audio.duration;
});

volume.addEventListener('input', () => { audio.volume = volume.value; });
audio.volume = volume.value;

audio.addEventListener('error', () => {
  artistEl.textContent = '⚠ Cannot load this audio. Check your internet or the audio_url.';
});

loadTrack(index, true);
