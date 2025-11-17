<?php

declare(strict_types=1);

namespace Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class ShowChatRoomsTest extends TestCase
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
		);

		$this->post(
			'/api/createChatRoom',
			[
				'user_ids' => [$user->json('id')],
			],
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response = $this->get(
			'/api/showChatRooms',
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(200);
		$response->assertJson([
			[
				'emails' => [
					'first@email.com',
					'test@email.com',
				],
			],
		]);
	}

	public function testChatRoomSharedReference(): void
	{
		$user = $this->post(
			'/api/registerUser',
			[
				'email' => 'first@email.com',
				'password' => 'password',
			],
		);

		$this->post(
			'/api/createChatRoom',
			[
				'user_ids' => [$user->json('id')],
			],
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$responseA = $this->get(
			'/api/showChatRooms',
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$jwtToken = $this->post(
			'/api/authenticateWithPassword',
			[
				'email' => 'first@email.com',
				'password' => 'password',
			],
		)->json('token');

		$responseB = $this->get(
			'/api/showChatRooms',
			[
				'Authorization' => 'Bearer ' . $jwtToken,
			],
		);

		$this->assertSame(
			$responseA->json(),
			$responseB->json(),
		);
	}

	public function testEmptyResult(): void
	{
		$response = $this->get(
			'/api/showChatRooms',
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(200);
		$response->json([]);
	}

}
