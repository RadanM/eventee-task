<?php

declare(strict_types=1);

namespace Api\Source\Http\Controllers;

final class PingController extends Controller
{

	public function __invoke(): string
	{
		return 'pong';
	}

}
