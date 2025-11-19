CREATE TABLE `messages` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`chat_room_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP NOT NULL,
	`text` longtext NOT NULL,
	PRIMARY KEY (`id`),
	INDEX idx_chat_room_id (chat_room_id),
	INDEX idx_created_at (created_at)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
