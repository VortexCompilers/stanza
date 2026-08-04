-- Fonte de verdade do banco StanzAI.
-- O back-end (backend-php/) e o motor de ML (ml-engine/) rodam contra
-- este schema; não há mais ORM/migrations definindo as tabelas.
CREATE DATABASE IF NOT EXISTS stanza;
USE stanza;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('author', 'reader') NOT NULL
);

CREATE TABLE texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    genre VARCHAR(100) NOT NULL,
    read_count INT DEFAULT 0,

    FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE reading_logs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    reader_id INT NOT NULL,
    text_id INT NOT NULL,
    started_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    time_spent_seconds INT NOT NULL,

    FOREIGN KEY (reader_id) REFERENCES users(id),
    FOREIGN KEY (text_id) REFERENCES texts(id)    
);