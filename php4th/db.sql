-- 1) データベース作成（utf8mb4）
CREATE DATABASE IF NOT EXISTS contactform
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

-- 2) ユーザー作成（localhostのみ）
CREATE USER 'contactuser'@'localhost' IDENTIFIED BY 'CtForm_2026!MxvQ';

-- 3) 権限付与
GRANT ALL PRIVILEGES ON contactform.* TO 'contactuser'@'localhost';
FLUSH PRIVILEGES;

-- 4) テーブル作成（utf8mb4）
USE contactform;

CREATE TABLE IF NOT EXISTS contactdata (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  gender INT NOT NULL,
  comment TEXT NULL,
  regdate DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
