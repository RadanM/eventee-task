<?php

declare(strict_types=1);

return [
	'default' => env('DB_CONNECTION', 'mysql'),
	'connections' => [
		'mysql' => [
			'driver' => 'mysql',
			'host' => env('DB_HOST', '127.0.0.1'),
			'port' => env('DB_PORT', '3306'),
			'database' => env('DB_DATABASE', 'laravel'),
			'username' => env('DB_USERNAME', 'root'),
			'password' => env('DB_PASSWORD', ''),
			'charset' => env('DB_CHARSET', 'utf8mb4'),
			'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
			'prefix' => '',
			'prefix_indexes' => true,
			'strict' => true,
			'engine' => null,
			'options' => extension_loaded('pdo_mysql') ? array_filter([
				PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
			]) : [],
		],
		'mysql-chat' => [
			'driver' => 'mysql',
			'host' => env('DB_CHAT_HOST', '127.0.0.1'),
			'port' => env('DB_CHAT_PORT', '3306'),
			'database' => env('DB_CHAT_DATABASE', 'laravel'),
			'username' => env('DB_CHAT_USERNAME', 'root'),
			'password' => env('DB_CHAT_PASSWORD', ''),
			'charset' => env('DB_CHAT_CHARSET', 'utf8mb4'),
			'collation' => env('DB_CHAT_COLLATION', 'utf8mb4_unicode_ci'),
			'prefix' => '',
			'prefix_indexes' => true,
			'strict' => true,
			'engine' => null,
			'options' => extension_loaded('pdo_mysql') ? array_filter([
				PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
			]) : [],
		],
	],
];
