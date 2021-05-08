DROP DATABASE IF EXISTS esports;
CREATE DATABASE esports;
USE esports;

CREATE TABLE games
(
  id    INT NOT NULL AUTO_INCREMENT,
  name  VARCHAR(255) NOT NULL,
  image VARCHAR(255),
  PRIMARY KEY (id)
);

INSERT INTO
  games(name, image)
VALUES
  ('Call of Duty: Black Ops 4', 'call_of_duty.jpg'),
  ('Counter-Strike: Global Offensive', 'counter_strike.jpg'),
  ('Fortnite', 'fortnite.jpg'),
  ('League of Legends', 'league_of_legends.jpg'),
  ('World of Warcraft', 'world_of_warcraft.jpg');

CREATE TABLE platforms
(
  id   INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO
  platforms(name)
VALUES
  ('Mobile'),
  ('PC'),
  ('PlayStation 4'),
  ('Switch'),
  ('Xbox One');

CREATE TABLE regions
(
  id   INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO
  regions(name)
VALUES
  ('Africa'),
  ('Asia'),
  ('Europe'),
  ('North America'),
  ('Oceania'),
  ('South America');

CREATE TABLE users
(
  id       INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (username)
);

INSERT INTO
  users(username, password)
VALUES
  ('alice123', /* pass123 */ '$2y$10$/DwEnEw/1FggY/L/asdUoO5KyIvYYrL9.cKp78wMvzxL8EI3RW12e'),
  ('bob456', /* pass456 */ '$2y$10$Ej/ahpS82EVl/rCvaRRk2utDBga/Fl5Hjh.F17oOWZRWSXJTbQhau');

CREATE TABLE tournaments
(
  id          INT NOT NULL AUTO_INCREMENT,
  title       VARCHAR(255) NOT NULL,
  game        INT NOT NULL,
  platform    INT NOT NULL,
  region      INT NOT NULL,
  date        DATE NOT NULL,
  time        TIME NOT NULL,
  description VARCHAR(4094) NOT NULL,
  creator     INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (game) REFERENCES games(id),
  FOREIGN KEY (platform) REFERENCES platforms(id),
  FOREIGN KEY (region) REFERENCES regions(id),
  FOREIGN KEY (creator) REFERENCES users(id)
);

INSERT INTO
  tournaments(title, game, platform, region, date, time, description, creator)
VALUES
  ('Korean Invitationals', 4, 2, 2, '2018-12-31', '17:00:00', 'Main League of Legends event in South Korea.', 1),
  ('VPG Variant 3v3', 1, 3, 2, '2018-12-27', '22:00:00', '3v3 format. Team registration is allowed.', 2),
  ('COUNTER STRIKE GO 5v5 GameShow18', 2, 5, 2, '2018-12-29', '23:30:00', 'Tournament format is single elimination. All Stages Best of 1. Semi Finals - Best of 3. Finals - Best of 3.', 1),
  ('EU Cup #4 - Winter', 5, 2, 3, '2018-12-15', '18:00:00', 'The Europe - Winter Cup #4 will be the ninth and final regional cup for Europe in the Road to BlizzCon for 2018.', 2),
  ('Worlds 2018', 4, 2, 4, '2018-12-30', '10:00:00', 'Worlds 2018 is being played in Seoul, South Korea.', 1),
  ('Fortnite Cup by Logitech G Qualifier #2', 3, 5, 4, '2018-12-17', '13:30:00', 'The second qualifier of the Fortnite Cup by Logitech G.', 2),
  ('Texas Shield 2v2 CSGO', 2, 5, 4, '2018-12-20', '21:30:00', 'Texas Shield is a CSGO 2v2 tournament using the wingman maps.', 1),
  ('NA Cup #5 - Winter', 5, 2, 4, '2018-12-22', '21:00:00', 'The North America - Winter Cup #4 is the final regional cup for North America for 2018.', 2),
  ('AbsoluteNAs 5v5 Best of 1 Wars', 1, 5, 4, '2018-12-23', '18:30:00', '5v5 Best of 1 Wars.', 1),
  ('Black Ops4 - 5v5 Variant', 1, 3, 6, '2018-12-18', '15:30:00', '5v5 Variant Black Ops 4 League.', 2),
  ('Fortnite Duo Cup 2v2', 3, 4, 6, '2018-12-28', '16:30:00', 'Duo format', 1),
  ('Platinum To Challenger #1 5v5 Tournament', 4, 2, 2, '2018-12-16', '13:30:00', 'All matches will be Single Elimination.', 2);

CREATE TABLE user_tournaments
(
  user       INT NOT NULL,
  tournament INT NOT NULL,
  PRIMARY KEY (user, tournament),
  FOREIGN KEY (user) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (tournament) REFERENCES tournaments(id) ON DELETE CASCADE
);
