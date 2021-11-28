DROP DATABASE IF EXISTS appDB;
CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(35) NOT NULL,
  `user_group` varchar(2) NOT NULL,
  `user_ed_group` varchar(40),
  PRIMARY KEY (`id`)
);

-- USERS

USE appDB;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `status` varchar(80) NOT NULL,
  `student_id` int(11) NOT NULL,
  `app_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`student_id`) REFERENCES `users` (`id`)
);

ALTER DATABASE appDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
ALTER TABLE appDB.users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.users CHANGE login login VARCHAR(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.users CHANGE user_ed_group user_ed_group VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.applications CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.applications CHANGE status status ENUM('Доступно', 'Отправлено', 'Принято', 'Одобрено', 'Отклонено') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

-- APPLICATIONS