-- create users table with email and password
CREATE TABLE `live`.`users` ( `email` VARCHAR(255), `password` VARCHAR(255), PRIMARY KEY (`email`(255))) ENGINE = MyISAM;

-- create test user
INSERT INTO `users`(`email`, `password`) VALUES ('johndoe@gmail.com', SHA('123456'));