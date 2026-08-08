CREATE DATABASE IF NOT EXISTS stanza;
USE stanza;

DROP TABLE IF EXISTS text_genres;
DROP TABLE IF EXISTS reading_logs;
DROP TABLE IF EXISTS embeddings;
DROP TABLE IF EXISTS text_genres;
DROP TABLE IF EXISTS texts;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    birthdate DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('reader', 'author', 'admin') NOT NULL DEFAULT 'reader'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    read_count INT DEFAULT 0,
	description VARCHAR(255) NOT NULL,
	role ENUM('livro', 'poesia', 'conto') NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    visibility ENUM('public', 'private') NOT NULL DEFAULT 'public',

    FOREIGN KEY (author_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE embeddings (
    id INT PRIMARY KEY,
    embedding TEXT NOT NULL,
    FOREIGN KEY (id) REFERENCES texts(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE reading_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reader_id INT NOT NULL,
    text_id INT NOT NULL,
    started_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    time_spent_seconds INT NOT NULL,

    FOREIGN KEY (reader_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (text_id) REFERENCES texts(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE text_genres (
    text_id INT NOT NULL,
    genre_id INT NOT NULL,
    PRIMARY KEY (text_id, genre_id),
    FOREIGN KEY (text_id) REFERENCES texts(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT IGNORE INTO genres (name) VALUES
('Fantasia'),
('Drama'),
('Romance'),
('Terror'),
('Ficção Científica'),
('Suspense'),
('Aventura'),
('Mistério'),
('Poesia Lírica'),
('Realismo Mágico'),
('Comédia'),
('Distopia');
