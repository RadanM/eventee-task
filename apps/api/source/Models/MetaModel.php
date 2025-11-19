<?php

declare(strict_types=1);

namespace Api\Source\Models;

use Illuminate\Database\Eloquent\Model;

abstract class MetaModel extends Model
{

	protected $connection = 'mysql';

}
