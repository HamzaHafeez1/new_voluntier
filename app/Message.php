<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $table='messages';
	public $timestamps = true;

	protected $appends = [
		'sender_name',
		'sender_logo',
		'sender_role',
	];

	public function getSenderNameAttribute(){
		if($this->user_role = 'volunteer'){
			$user = User::find($this->sender_id);
			return $user->first_name.' '.$user->last_name;
		}else{
			return User::find($this->sender_id)->org_name;
		}
	}

	public function getSenderLogoAttribute(){
		return User::find($this->sender_id)->logo_img;
	}

	public function getSenderRoleAttribute(){
		return User::find($this->sender_id)->user_role;
	}

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
