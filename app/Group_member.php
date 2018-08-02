<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group_member extends Model
{	 protected $table='group_members';
	const PENDING = 1;
	const APPROVED = 2;
	const DECLINED = 0;
    //
}
