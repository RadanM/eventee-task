<?php

declare(strict_types=1);

use Api\Source\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('/authenticateWithPassword', Controllers\AuthenticateWithPasswordController::class);
Route::get('/ping', Controllers\PingController::class);
Route::post('/registerUser', Controllers\RegisterUserController::class);

Route::middleware([Api\Source\Http\Middlewares\EnsureTokenIsValid::class])->group(function () {
	Route::post('/createChatRoom', Controllers\CreateChatRoomController::class);
	Route::get('/listAvailableUsers', Controllers\ListAvailableUsersController::class);
	Route::get('/listUsersInChatRoom', Controllers\ListUsersInChatRoomController::class);
	Route::get('/showChatRooms', Controllers\ShowChatRoomsController::class);
	Route::get('/showMessages', Controllers\ShowMessagesController::class);
	Route::post('/storeMessage', Controllers\StoreMessageController::class);
});
