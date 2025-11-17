<?php

declare(strict_types=1);

namespace Api\Source\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class User extends Authenticatable implements JWTSubject
{

	protected $table = 'users';

	protected $fillable = [
		'chat_rooms_ids_hash',
		'email',
		'password',
	];

	protected $hidden = [
		'password',
	];

	public $timestamps = false;

	public function getJWTIdentifier(): int
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims(): array
	{
		return [];
	}

	public function addChatRoom(int $chatRoomId): void
	{
		$ids = $this->getChatRoomsIds();

		if (in_array($chatRoomId, $ids, true) === false) {
			$ids[] = $chatRoomId;
			$this->chat_rooms_ids_hash = base64_encode(implode('-', $ids));
			$this->save();
		}
	}

	/**
	 * @return array<int>
	 */
	public function getChatRoomsIds(): array
	{
		return $this->chat_rooms_ids_hash === null
			? []
			: explode('-', base64_decode($this->chat_rooms_ids_hash));
	}

}
