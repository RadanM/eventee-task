<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Database;
use Illuminate\Http;
use Illuminate\Support;

final class CreateChatRoomController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$request->validate([
			'user_ids' => 'required|array|min:1',
			'user_ids.*' => 'integer',
		]);

		$userIds = array_unique([
			auth()->id(),
			...$request->input(['user_ids']),
		]);

		$users = Models\User::whereIn('id', $userIds)->get();

		$missingIds = array_diff(
			$userIds,
			$users->pluck('id')->toArray(),
		);

		if ($missingIds) {
			return response()->json([
				'message' => 'Some user IDs do not exist.',
				'missingIds' => array_values($missingIds),
			], 422);
		}

		sort($userIds);

		Support\Facades\DB::beginTransaction();

		$payload = [];

		try {
			$chatRoom = Models\ChatRoom::create([
				'user_ids_hash' => base64_encode(implode('-', $userIds)),
			]);
		} catch (Database\UniqueConstraintViolationException) {
			$chatRoom = null;
		}

		if ($chatRoom !== null) {
			foreach ($users as $user) {
				$user->addChatRoom($chatRoom->id);
			}

			$payload = [
				'id' => $chatRoom->id,
				'emails' => $users->pluck('email')->toArray(),
			];

			sort($payload['emails']);
		}

		Support\Facades\DB::commit();

		return response()->json($payload);
	}

}
