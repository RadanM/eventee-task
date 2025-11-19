<?php

declare(strict_types=1);

namespace Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class StoreAndShowMessagesTest extends TestCase
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

		$chatRoomId = $this->post(
			'/api/createChatRoom',
			[
				'user_ids' => [$user->json('id')],
			],
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		)->json('id');

		$this->post(
			'/api/storeMessage',
			[
				'chatRoomId' => $chatRoomId,
				'text' => 'Test message',
			],
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response = $this->get(
			'/api/showMessages?chatRoomId=' . $chatRoomId,
			[
				'Authorization' => 'Bearer ' . $this->getJwtToken(),
			],
		);

		$response->assertStatus(200);
		$response->assertJson([
			'messages' => [
				[
					'chat_room_id' => $chatRoomId,
					'text' => 'Test message',
				],
			],
		]);
	}

}
