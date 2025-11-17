<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Http;
use Illuminate\Support;

final class ShowChatRoomsController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$chatRooms = Models\ChatRoom::whereIn(
			'id',
			Support\Facades\Auth::user()->getChatRoomsIds(),
		)->get();

		$userIds = [];

		foreach ($chatRooms as $chatRoom) {
			foreach ($chatRoom->getUserIds() as $userId) {
				if (in_array($userId, $userIds, true) === false) {
					$userIds[] = $userId;
				}
			}
		}

		$users = Models\User::whereIn('id', $userIds)->get()->keyBy('id');

		$responseBody = [];

		foreach ($chatRooms as $chatRoom) {
			$chatRoomResponse = [
				'id' => $chatRoom->id,
				'emails' => [],
			];

			foreach ($chatRoom->getUserIds() as $userId) {
				$chatRoomResponse['emails'][] = $users[$userId]->email;
			}

			sort($chatRoomResponse['emails']);

			$responseBody[] = $chatRoomResponse;
		}

		return response()->json($responseBody);
	}

}
