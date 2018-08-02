<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{   protected $table='groups';
	const GROUP_ADMIN = 1;
	const GROUP_MEMBER = 2;

    public function users()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'group_id', 'user_id');
    }
}
