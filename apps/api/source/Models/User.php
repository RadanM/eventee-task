<?php

declare(strict_types=1);

namespace Api\Source\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class User extends Authenticatable implements JWTSubject
{

	protected $table = 'users';

	protected $fillable = [
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

}
