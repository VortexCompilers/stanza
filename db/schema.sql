-- Fonte de verdade do banco StanzAI.
-- O back-end (backend-basico/, backend-php/) roda contra este schema;
-- não há ORM/migrations definindo as tabelas.
--
-- `role` é uma hierarquia, não categorias isoladas: 'admin' inclui as
-- permissões de 'author', que inclui as de 'reader'. Isso é aplicado no
-- código (PHP), não no banco — ver docs/plano-apresentacao-14-08.md.
CREATE DATABASE IF NOT EXISTS stanza;
USE stanza;

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
    genre VARCHAR(100) NOT NULL,
    read_count INT DEFAULT 0, 
	description VARCHAR(255) NOT NULL,
	role ENUM('livro', 'poesia', 'conto') NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    visibility ENUM('public', 'private') NOT NULL DEFAULT 'public',

    FOREIGN KEY (author_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE embeddings ( 
	id int PRIMARY KEY, 
	embeddings TEXT, 
	FOREIGN KEY (id) REFERENCES texts(id) 
);

CREATE TABLE reading_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reader_id INT NOT NULL,
    text_id INT NOT NULL,
    started_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    time_spent_seconds INT NOT NULL,

    FOREIGN KEY (reader_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (text_id) REFERENCES texts(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
