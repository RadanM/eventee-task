<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

use Illuminate\Http;
use Illuminate\Support;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthenticateWithPasswordController extends Controller
{

	public function __invoke(Http\Request $request): Http\JsonResponse
	{
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		if (Support\Facades\Auth::attempt($credentials)) {
			return response()->json([
				'token' => JWTAuth::fromUser(
					Support\Facades\Auth::user(),
				),
			]);
		}

		return response()->json([
			'success' => false,
			'message' => 'Invalid credentials',
		], 401);
	}

}
