CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`email` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
