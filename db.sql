DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `usr_id` INT(10) NOT NULL AUTO_INCREMENT,
  `usr_name` VARCHAR(100) NOT NULL,
  `usr_password` VARCHAR(100) NOT NULL,
  `usr_email` VARCHAR(60) NOT NULL,
  `usrl_id` INT NULL,
  `lng_id` INT NULL,
  `usr_active` INT NOT NULL,
  `usr_question` VARCHAR(100) NULL,
  `usr_answer` VARCHAR(100) NULL,
  `usr_picture` VARCHAR(255) NULL,
  `usr_password_salt` VARCHAR(100) NULL,
  `usr_registration_date` DATETIME NULL,
  `usr_registration_token` VARCHAR(100) NULL,
  `usr_email_confirmed` BINARY NOT NULL,
  PRIMARY KEY (`usr_id`))
  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `car`;
CREATE TABLE `car` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `brand` VARCHAR(100) NULL,
  `name_model` VARCHAR(100) NULL,
  `detail` VARCHAR(1024) NULL,
  `photo` VARCHAR(100) NULL,
   `created_at` DATETIME,
  PRIMARY KEY (`id`));
  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NULL,
  `second_name` VARCHAR(100) NULL,
  `email` VARCHAR(60) NULL,
  `city` VARCHAR(50) NULL,
  `phone` VARCHAR(20) NULL,
  `car_id` INT(10) NULL,
  `is_read` INT(1) NULL,
   `created_at` DATETIME,
  PRIMARY KEY (`id`));
  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (usr_id, usr_name, usr_password, usr_email, usrl_id, lng_id, usr_active, usr_question, usr_answer, usr_picture, usr_password_salt, usr_registration_date, usr_registration_token, usr_email_confirmed)
VALUES  ('1', 'admin', '123123', '123123@mail.ru', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, 1)

