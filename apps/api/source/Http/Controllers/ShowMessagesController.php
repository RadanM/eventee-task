<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Http;
use Illuminate\Support;

final class ShowMessagesController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$request->validate([
			'chatRoomId' => 'required|integer',
			'lastMessageId' => 'integer',
		]);

		$user = Support\Facades\Auth::user();

		$chatRoomId = (int)$request->query('chatRoomId');

		if (in_array($chatRoomId, $user->getChatRoomsIds(), true) === false) {
			return response()->json([
				'message' => 'Chat room id does not belong to the user.',
			], 422);
		}

		$limit = 20;

		$lastMessageId = $request->query('lastMessageId', 0);

		$messages = Models\Message::where('chat_room_id', $chatRoomId)
			->when(
				$lastMessageId > 0,
				static function ($query) use ($request) {
					$query->where('id', '<', $request->query('lastMessageId'));
				}
			)
			->orderBy('created_at', 'desc')
			->limit($limit + 1)
			->get()
			->toArray();

		$isLast = count($messages) <= $limit;

		if ($isLast === false) {
			array_pop($messages);
		}

		return response()->json([
			'metadata' => [
				'lastMessageId' => $messages !== [] ? end($messages)['id'] : null,
				'isLast' => $isLast,
			],
			'messages' => $messages,
		]);
	}

}
