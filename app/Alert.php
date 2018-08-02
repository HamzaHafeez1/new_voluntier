<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
	const ALERT_FOLLOW = 1;
	const ALERT_INVITATION = 2;
	const ALERT_CONNECT_CONFIRM_REQUEST = 3;
	const ALERT_TRACK_CONFIRM_REQUEST = 4;
	const ALERT_NEW_POST = 5;
	const ALERT_ACCEPT = 6;
	const ALERT_DECLINE = 7;
	const ALERT_JOIN_OPPORTUNITY = 8;
	const ALERT_CREATE_PRIVATE_OPPORTUNITY = 9;

	/******************GROUP*********************/
	const ALERT_GROUP_INVITATION = 10;

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
