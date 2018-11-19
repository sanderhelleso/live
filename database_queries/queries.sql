-- create users table with id, email and password
CREATE TABLE `live`.`users` ( `user_id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`user_id`), UNIQUE (`email`)) ENGINE = MyISAM;

-- create test user
INSERT INTO `users` (`user_id`, `email`, `password`) VALUES (NULL, 'johndoe@gmail.com', SHA1('123456'));

-- create users_data table
CREATE TABLE `live`.`users_data` ( `user_id` INT NOT NULL , `first_name` VARCHAR(50) NOT NULL , `last_name` VARCHAR(50) NOT NULL , `age` INT(100) NOT NULL , `country` VARCHAR(255) NOT NULL , `state` VARCHAR(255) NOT NULL , `street_address` VARCHAR(255) NOT NULL , `phone_number` VARCHAR(50) NOT NULL , `newsletter` BOOLEAN NOT NULL , PRIMARY KEY (`user_id`)) ENGINE = MyISAM;

-- create test user data
INSERT INTO `users_data` (`user_id`, `first_name`, `last_name`, `age`, `country`, `state`, `street_address`, `phone_number`, `newsletter`) VALUES ('1', 'john', 'doe', '22', 'Norway', 'More And Romsdal', 'Imaginary Street 123', '12345678', '1');