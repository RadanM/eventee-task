<?php

namespace Api\Source\Models;

final class Message extends ChatModel
{

	protected $table = 'messages';

	protected $fillable = [
		'chat_room_id',
		'user_id',
		'text',
	];

}
