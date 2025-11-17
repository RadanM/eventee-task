CREATE TABLE `chat_rooms` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`created_at` TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`user_ids_hash` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `user_ids_hash_unique` (`user_ids_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`email` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`chat_rooms_ids_hash` varchar(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
