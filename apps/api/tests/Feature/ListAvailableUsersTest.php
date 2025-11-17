<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class ListAvailableUsersTest extends TestCase
{

	use DatabaseTransactions;

	public function testSuccess(): void
	{
		$user = $this->post(
			'/api/registerUser',
			[
				'email' => 'first@email.com',
				'password' => 'password',
			],
		)->json();

		$response = $this->get(
			'/api/listAvailableUsers',
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(200);
		$response->assertJson([
			[
				'id' => $user['id'],
				'email' => $user['email'],
			],
		]);
	}

}
