-- create users table with id, email and password
CREATE TABLE `live`.`users` ( `user_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL, UNIQUE (`email`)) ENGINE = INNODB;

-- create test user
INSERT INTO `users` (`user_id`, `email`, `password`) VALUES (NULL, 'johndoe@gmail.com', SHA1('123456'));

-- create users_data table
CREATE TABLE `live`.`users_data` ( `user_id` INT NOT NULL, `first_name` VARCHAR(50) NOT NULL , `last_name` VARCHAR(50) NOT NULL , `age` INT(100) NOT NULL , `country` VARCHAR(255) NOT NULL , `state` VARCHAR(255) NOT NULL , `street_address` VARCHAR(255) NOT NULL , `phone_number` VARCHAR(50) NOT NULL , `avatar` LONGBLOB NULL, `newsletter` BOOLEAN NOT NULL , FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE = INNODB;

-- create test user data
INSERT INTO `users_data` (`user_id`, `first_name`, `last_name`, `age`, `country`, `state`, `street_address`, `phone_number`, `avatar`, `newsletter`) VALUES ('1', 'john', 'doe', '22', 'Norway', 'More And Romsdal', 'Imaginary Street 123', '12345678', NULL, '1');

-- create users_auth table
CREATE TABLE `live`.`users_auth` ( `user_id` INT NOT NULL, `token` VARCHAR(128) NULL , `issued_at` BIGINT NULL , UNIQUE (`token`), FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE = INNODB;

-- create test users_auth data
INSERT INTO `users_auth` (`user_id`, `token`, `issued_at`) VALUES ('1', 'd81e0f58d1ea232c48ac237d885d79c9a2876397dfb5fc61b90949d86de5a4a8c07656563131061e73aa44874016d9c25a1ec55e5ff740baa7cf06b67b68592b', '1542679935801');

-- create forgot password table
CREATE TABLE `live`.`forgot_password` ( `user_id` INT NOT NULL , `reset_url` VARCHAR(128) NULL , PRIMARY KEY (`user_id`), UNIQUE (`reset_url`), FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE = INNODB;

-- create test forgot password data
INSERT INTO `forgot_password`(`user_id`, `reset_url`) VALUES (1,'d81e0f58d1ea232c48ac237d885d79c9a2876397dfb5fc61b90949d86de5a4a8c07656563131061e73aa44874016d9c25a1ec55e5ff740baa7cf06b67b68592b');
