DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Poems;
DROP TABLE IF EXISTS Playlists;
DROP TABLE IF EXISTS PlaylistItems;

-- CREATE TABLE
-- Creating the Users table
CREATE TABLE Users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    hashed_password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL CHECK(role IN ('admin', 'creator', 'user')),
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creating the Poems table
CREATE TABLE Poems (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    creator_id INTEGER,
    genre VARCHAR(255) CHECK(genre IN ('Romantic', 'National', 'Sad', 'Epic', 'Haiku')),
    content TEXT,
    image_path VARCHAR(255),
    audio_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Creating the Playlists table
CREATE TABLE Playlists (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    owner_id INTEGER,
    image_path VARCHAR(255),
    is_private BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Creating the PlaylistItems table (to store the relationship between Playlists and Poems)
CREATE TABLE PlaylistItems (
    playlist_id INTEGER,
    poem_id INTEGER,
    PRIMARY KEY (playlist_id, poem_id),
    FOREIGN KEY (playlist_id) REFERENCES Playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (poem_id) REFERENCES Poems(id) ON DELETE CASCADE
);

-- Creating the UserLikedPoems table
CREATE TABLE UserLikedPoems (
    user_id INTEGER,
    poem_id INTEGER,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, poem_id),
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (poem_id) REFERENCES Poems(id) ON DELETE CASCADE
);

-- Creating the UserSavedPlaylists table
CREATE TABLE UserSavedPlaylists (
    user_id INTEGER,
    playlist_id INTEGER,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, playlist_id),
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (playlist_id) REFERENCES Playlists(id) ON DELETE CASCADE
);

-- TRIGGERS
-- Triggers to update 'updated_at' column
CREATE OR REPLACE FUNCTION update_modified_column()
RETURNS TRIGGER AS $$
BEGIN
   NEW.updated_at = now(); 
   RETURN NEW;
END;
$$ language 'plpgsql';

CREATE TRIGGER update_user_modtime 
BEFORE UPDATE ON Users 
FOR EACH ROW 
EXECUTE PROCEDURE update_modified_column();

CREATE TRIGGER update_poem_modtime 
BEFORE UPDATE ON Poems 
FOR EACH ROW 
EXECUTE PROCEDURE update_modified_column();

CREATE TRIGGER update_playlist_modtime 
BEFORE UPDATE ON Playlists 
FOR EACH ROW 
EXECUTE PROCEDURE update_modified_column();

-- DATA SEEDING
-- Seeding data into Users table, password is "password"
INSERT INTO Users (username, email, description, hashed_password, role, image_path)
VALUES 
('JohnDoe', 'john@example.com', 'Hi, nice to meet you!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'user', '/img/queencard.jpeg'),
('JaneDoe', 'jane@example.com', 'Hi, nice to meet you!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/queencard.jpeg'),
('AdminUser', 'admin@example.com', 'Hi, nice to meet you!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'admin', '/img/queencard.jpeg'),
('EmilySmith', 'emily@example.com', 'Hi, nice to meet you!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'user', '/img/queencard.jpeg'),
('RobertBrown', 'robert@example.com', 'Hi, nice to meet you!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/queencard.jpeg')
;



-- Seeding data into Poems table
INSERT INTO Poems (title, creator_id, genre, content, image_path, audio_path)
VALUES
('The Lonely Mountain', 2, 'Epic',
E'In the realm of code, where logic is king,\n
Binary whispers and algorithms sing.\n
Strings of data, in memory they lie,\n
Under silicon skies, where electrons fly.\n

Functions and loops, in harmony they play,\n
Crafting worlds in arrays, night and day.\n
In the heart of the machine, no room for the absurd,\n
Every action defined, by a well-written word.\n

Errors and bugs, like shadows they creep,\n
In the depth of the code, where secrets sleep.\n
But fear not, for the coder is near,\n
With a mind full of logic, and devoid of fear.\n

With every line written, and every test run,\n
A battle is fought, a victory won.\n
For in this digital realm, creation is key,\n
Crafted by coders, for all to see.'
, '/img/queencard.jpeg', '/audio/queencard.mp3'),
('Love in Springtime', 5, 'Romantic', 'A romantic poem about finding love in spring.', '/img/queencard.jpeg', '/audio/queencard.mp3'),
('Sorrowful Departure', 2, 'Sad', 'A sad poem about a sorrowful departure.', '/img/queencard.jpeg', '/audio/queencard.mp3'),
('Cherry Blossoms Dancing', 5, 'Haiku', 'A haiku about cherry blossoms dancing in the wind.', '/img/queencard.jpeg', '/audio/queencard.mp3'),
('The Mighty Ocean Waves', 2, 'Epic', 'An epic poem about the mighty ocean waves.', '/img/queencard.jpeg', '/audio/queencard.mp3');

-- Seeding data into Playlists table
INSERT INTO Playlists (title, owner_id, image_path, is_private)
VALUES 
('Epic Journeys', 1, '/img/queencard.jpeg' , FALSE),
('Romantic Musings', 4, '/img/queencard.jpeg' , TRUE),
('Sad Goodbyes', 1, '/img/queencard.jpeg' , FALSE),
('Nature in Verse', 4, '/img/queencard.jpeg' , TRUE),
('Powerful Forces ofNature', 1, '/img/queencard.jpeg' , FALSE);

-- Seeding data into PlaylistItems table
INSERT INTO PlaylistItems (playlist_id, poem_id)
VALUES 
(1, 1),
(1, 5),
(2, 2),
(3, 3),
(4, 4),
(5, 1),
(5, 5);

-- Seeding data into UserLikedPoems table
INSERT INTO UserLikedPoems (user_id, poem_id)
VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(4, 1),
(4, 2),
(5, 3),
(5, 4);

-- Seeding data into UserSavedPlaylists table
INSERT INTO UserSavedPlaylists (user_id, playlist_id)
VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(4, 1),
(4, 2),
(5, 3),
(5, 4);
