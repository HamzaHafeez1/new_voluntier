<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $appends = [
		'org_name',
		'org_logo',
	];

	public function getOrgNameAttribute(){
		if($this->review_from != null){
			return User::find($this->review_from)->org_name;
		}else{
			return '';
		}
	}

	public function getOrgLogoAttribute(){
		if($this->review_from != null){
			return User::find($this->review_from)->logo_img;
		}else{
			return '';
		}
	}

    public function userReviewFrom()
    {
        return $this->belongsTo(User::class, 'review_from', 'id');
    }

    public function userReviewTo()
    {
        return $this->belongsTo(User::class, 'review_to', 'id');
    }
}
