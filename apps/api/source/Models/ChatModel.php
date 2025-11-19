<?php

namespace Api\Source\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ChatModel extends Model
{

	protected $connection = 'mysql-chat';

}
