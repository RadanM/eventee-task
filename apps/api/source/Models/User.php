<?php

declare(strict_types=1);

namespace Api\Source\Models;

use Illuminate\Database\Eloquent\Model;

final class User extends Model
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

}
