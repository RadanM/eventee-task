<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Http;
use Illuminate\Support;

final class StoreMessageController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$request->validate([
			'chatRoomId' => 'required|integer',
			'text' => 'required|string',
		]);

		$user = Support\Facades\Auth::user();

		if (in_array($request->input('chatRoomId'), $user->getChatRoomsIds(), true) === false) {
			return response()->json([
				'message' => 'Chat room id does not belong to the user.',
			], 422);
		}

		$message = Models\Message::create([
			'chat_room_id' => $request->input('chatRoomId'),
			'user_id' => $user->id,
			'text' => $request->input('text'),
		]);

		return response()->json($message);
	}

}
