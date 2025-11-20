<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Http;

final class ListUsersInChatRoomController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$request->validate([
			'chatRoomId' => 'required|integer',
		]);

		return response()->json(
			Models\User::whereIn('id', Models\ChatRoom::find($request->query('chatRoomId'))->getUserIds())
				->select('id', 'email')
				->get()
				->toArray(),
		);
	}

}
