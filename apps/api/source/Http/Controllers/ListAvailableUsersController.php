<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Http;

final class ListAvailableUsersController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$users = Models\User::where('id', '!=', auth()->id())
			->select('id', 'email')
			->get()
			->toArray();

		return response()->json($users);
	}

}
