<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		api: __DIR__ . '/../routes/api.php',
	)
	->withMiddleware(function (Middleware $middleware): void {})
	->withExceptions(function (Exceptions $exceptions): void {})
	->create();

$app->useAppPath(__DIR__. '/../source');

return $app;
