<?php

declare(strict_types=1);

use Api\Source\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/ping', Controllers\PingController::class);
Route::post('/registerUser', Controllers\RegisterUserController::class);
