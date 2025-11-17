<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class CreateChatRoomTest extends TestCase
{

	use DatabaseTransactions;

	public function testSuccess(): void
	{
		$user = $this->post(
			'/api/registerUser',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
		);

		$response = $this->post(
			'/api/createChatRoom',
			[
				'user_ids' => [$user->json('id')],
			],
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(200);
	}

	public function testIdempotency(): void
	{
		$user = $this->post(
			'/api/registerUser',
			[
				'email' => 'test@email.com',
				'password' => 'password',
			],
		);

		for ($i = 0; $i < 3; ++$i) {
			$response = $this->post(
				'/api/createChatRoom',
				[
					'user_ids' => [$user->json('id')],
				],
				[
					'Authorization' => 'Bearer ' . $this->getJwtToken(),
				],
			);

			$response->assertStatus(200);
		}
	}

	public function testMissingIdsFailure()
	{
		$response = $this->post(
			'/api/createChatRoom',
			[
				'user_ids' => [-1],
			],
			[
				'Accept' => 'application/json',
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(422);
		$response->assertJson([
			'message' => 'Some user IDs do not exist.',
		]);
	}

	public function testIncorrectPayload(): void
	{
		$response = $this->post(
			'/api/createChatRoom',
			[
				'user_ids' => '1-2-3',
			],
			[
				'Accept' => 'application/json',
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(422);
	}

	public function testUnauthorizedAccess(): void
	{
		$response = $this->post(
			'/api/createChatRoom',
			[
				'user_ids' => [1],
			],
		);

		$response->assertStatus(401);
	}

}
