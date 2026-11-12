CREATE DATABASE IF NOT EXISTS sia_multimedia CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sia_multimedia;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS videos;
DROP TABLE IF EXISTS tracks;
DROP TABLE IF EXISTS games;

CREATE TABLE users (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  full_name     VARCHAR(100) NOT NULL,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  email         VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE videos (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(150) NOT NULL,
  creator       VARCHAR(100) NOT NULL,
  source_site   VARCHAR(100) NOT NULL,
  embed_url     VARCHAR(255) NOT NULL,
  thumbnail_url VARCHAR(255) NOT NULL,
  description   TEXT
);

CREATE TABLE tracks (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(150) NOT NULL,
  artist      VARCHAR(100) NOT NULL,
  source_site VARCHAR(100) NOT NULL,
  audio_url   VARCHAR(255) NOT NULL,
  cover_url   VARCHAR(255) NOT NULL,
  description TEXT
);

CREATE TABLE games (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(100) NOT NULL,
  description TEXT,
  game_path   VARCHAR(255) NOT NULL,
  thumbnail   VARCHAR(255) NOT NULL
);

INSERT INTO videos (title, creator, source_site, embed_url, thumbnail_url, description) VALUES
('Big Buck Bunny', 'Blender Foundation', 'YouTube', 'https://www.youtube.com/embed/aqz-KE-bpKQ', 'https://img.youtube.com/vi/aqz-KE-bpKQ/hqdefault.jpg', 'A giant rabbit gets revenge on three bullying rodents. Open-source animated short.'),
('Sintel', 'Blender Foundation', 'YouTube', 'https://www.youtube.com/embed/eRsGyueVLvQ', 'https://img.youtube.com/vi/eRsGyueVLvQ/hqdefault.jpg', 'A young woman searches for her dragon friend. Open-source animated short.'),
('Tears of Steel', 'Blender Foundation', 'YouTube', 'https://www.youtube.com/embed/R6MlUcmOul8', 'https://img.youtube.com/vi/R6MlUcmOul8/hqdefault.jpg', 'A sci-fi short film mixing live action and CGI.'),
('Elephants Dream', 'Blender Foundation', 'YouTube', 'https://www.youtube.com/embed/TLkA0RELQ1g', 'https://img.youtube.com/vi/TLkA0RELQ1g/hqdefault.jpg', 'The first open movie made with Blender.'),
('Cosmos Laundromat', 'Blender Foundation', 'YouTube', 'https://www.youtube.com/embed/Y-rmzh0PI3c', 'https://img.youtube.com/vi/Y-rmzh0PI3c/hqdefault.jpg', 'A sheep on a lonely island meets a salesman with a strange offer.');

INSERT INTO tracks (title, artist, source_site, audio_url, cover_url, description) VALUES
('Song 1', 'SoundHelix', 'SoundHelix.com', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', 'images/cover1.svg', 'Royalty-free electronic demo track.'),
('Song 2', 'SoundHelix', 'SoundHelix.com', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3', 'images/cover2.svg', 'Royalty-free demo track.'),
('Song 3', 'SoundHelix', 'SoundHelix.com', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3', 'images/cover3.svg', 'Royalty-free demo track.'),
('Song 4', 'SoundHelix', 'SoundHelix.com', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3', 'images/cover4.svg', 'Royalty-free demo track.'),
('Song 5', 'SoundHelix', 'SoundHelix.com', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3', 'images/cover5.svg', 'Royalty-free demo track.');

INSERT INTO games (title, description, game_path, thumbnail) VALUES
('Tic-Tac-Toe', 'Play X against the computer. Get 3 in a row to win!', 'games/tictactoe/index.php', 'images/game_tictactoe.svg'),
('Memory Match', 'Flip the cards and find all the matching pairs.', 'games/memory/index.php', 'images/game_memory.svg'),
('Floppy Bird', 'Tap or press Space to fly through the pipes.', 'games/floppy/index.php', 'images/game_floppy.svg');
