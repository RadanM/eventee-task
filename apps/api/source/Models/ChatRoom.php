<?php

declare(strict_types=1);

namespace Api\Source\Models;

use Illuminate\Database\Eloquent\Model;

final class ChatRoom extends Model
{

	protected $table = 'chat_rooms';

	protected $fillable = [
		'user_ids_hash',
	];

	/**
	 * @return array<int>
	 */
	public function getUserIds(): array
	{
		return $this->user_ids_hash === null
			? []
			: explode('-', base64_decode($this->user_ids_hash));
	}

}
