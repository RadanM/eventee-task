<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class AuthenticateWithPasswordTest extends TestCase
{

	use DatabaseTransactions;

	protected function setUp(): void
	{
		parent::setUp();

		$this->post(
			'/api/registerUser',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
		);
	}

	public function testSuccess(): void
	{
		$response = $this->post(
			'/api/authenticateWithPassword',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
		);

		$response->assertStatus(200);
		$response->assertJsonStructure([
			'token',
		]);
	}

	public function testIncorrectPassword(): void
	{
		$response = $this->post(
			'/api/authenticateWithPassword',
			[
				'email' => 'test@email.com',
				'password' => 'wrongPassword',
			],
		);

		$response->assertStatus(401);
	}

}
