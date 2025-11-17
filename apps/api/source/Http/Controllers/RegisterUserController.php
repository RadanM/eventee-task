<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Api\Source\Models;
use Illuminate\Http;
use Illuminate\Support;

final class RegisterUserController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$request->validate([
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6',
		]);

		$user = Models\User::create([
			'email' => $request->input('email'),
			'password' => Support\Facades\Hash::make($request->input('password')),
		]);

		return response()->json(
			data: [
				'id' => $user->id,
				'email' => $user->email,
			],
			status: 201,
		);
	}

}
