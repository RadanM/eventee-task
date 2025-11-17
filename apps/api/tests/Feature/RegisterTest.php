<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class RegisterTest extends TestCase
{

	use DatabaseTransactions;

	public function testRegisterUserSuccess(): void
	{
		$response = $this->post(
			'/api/registerUser',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
		);

		$response->assertStatus(201);
		$response->assertJson([
			'email' => 'test@email.com',
		]);
	}

	public function testRegisterUserConflict(): void
	{
		$this->post(
			'/api/registerUser',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
		);

		$response = $this->post(
			'/api/registerUser',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
			[
				'Accept' => 'application/json',
			],
		);

		$response->assertStatus(422);
		$response->assertJson([
			'message' => 'The email has already been taken.',
			'errors' => [
				'email' => [
					'The email has already been taken.',
				]
			],
		]);
	}

	public function testRegisterUserIncorrectEmail(): void
	{
		$response = $this->post(
			'/api/registerUser',
			[
				'email' => 'test',
				'password' => 'password',
			],
			[
				'Accept' => 'application/json',
			],
		);

		$response->assertStatus(422);
		$response->assertJson([
			'message' => 'The email field must be a valid email address.',
			'errors' => [
				'email' => [
					'The email field must be a valid email address.',
				]
			],
		]);
	}

}
