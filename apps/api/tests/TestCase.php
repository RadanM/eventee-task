<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

	private ?string $jwtToken = null;

	protected function getJwtToken(): string
	{
		if ($this->jwtToken === null) {
			$this->post(
				'/api/registerUser',
				[
					'email' => 'test@email.com',
					'password' => 'password',
				],
			);

			$response = $this->post(
				'/api/authenticateWithPassword',
				[
					'email' => 'test@email.com',
					'password' => 'password',
				],
			);

			$this->jwtToken = $response->json('token');

		}

		return $this->jwtToken;
	}

}
