<?php

namespace Api\Source\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureTokenIsValid
{

	/**
	 * @param Closure(Request): (Response) $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		try {
			$user = JWTAuth::parseToken()->authenticate();

			if (!$user) {
				return response()->json(['error' => 'User not found'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'Access denied'], 401);
		}

		auth()->login($user);

		return $next($request);
	}

}
