<?php

declare(strict_types=1);

return [
	'guards' => [
		'api' => [
			'driver' => 'jwt',
			'provider' => 'users',
		],
	],
	'providers' => [
		'users' => [
			'driver' => 'eloquent',
			'model' => Api\Source\Models\User::class,
		],
	]
];
