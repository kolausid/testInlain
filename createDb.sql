-- Создание базы данных с кодировкой utf8
CREATE DATABASE IF NOT EXISTS mydatabase
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_general_ci;

-- Переключение на созданную базу данных
USE mydatabase;

-- Таблица posts
CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  INDEX idx_userId (userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Таблица comments
CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  postId INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  INDEX idx_postId (postId),
  FULLTEXT INDEX idx_body (body),
  CONSTRAINT fk_post FOREIGN KEY (postId)
    REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;