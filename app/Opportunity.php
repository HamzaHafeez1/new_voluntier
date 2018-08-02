<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
	const REGULAR_OPPORTUNITY = 1;
	const IRREGULAR_OPPORTUNITY = 2;
	
	protected $table = 'opportunities';

	protected $fillable =[
		'org_id',
		'title',
		'description',
		'category_id',
		'code',
		'street_addr1',
		'street_addr2',
		'city',
		'state',
		'zipcode',
		'start_date',
		'end_date',
		'contact_name',
		'contact_email',
		'contact_number',
		'timerange',
		'lat',
		'lng',
		'compensation',
		'activity',
		'qualification',
		'weekdays',
		'status',
		'is_deleted',
	];

	public $timestamps = true;

	protected $appends = [
		'org_name',
		'org_logo',
		'opportunity_type',
		'opportunity_member',
	];

	public function getOrgNameAttribute(){
		$poster = User::find($this->org_id);
		return $poster->org_name;
	}

	public function getOrgLogoAttribute(){
		$poster = User::find($this->org_id);
		return $poster->logo_img;
	}

	public function getOpportunityTypeAttribute(){
		if($this->category_id != 0){
			$categories = Opportunity_category::find($this->category_id);
			return $categories->name;
		}else{
			return '';
		}
	}

	public function getOpportunityMemberAttribute(){
		$members = Opportunity_member::where('oppor_id',$this->id)->where('is_deleted','<>',1)->get();
		return $members;
	}
//
//	public function getOrgMembersAttribute(){
//		$members = Opportunity_members::where('oppor_id',$this->id)->orderby('created_at')->get();
//		return $members;
//	}
    public function activities()
    {
        return $this->hasMany(Activity::class, 'oppor_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'opportunity_members', 'oppor_id', 'user_id');
    }

    public function categoriOpp()
    {
        return $this->belongsTo(User::class, 'category_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(Tracking::class, 'oppor_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(User::class, 'org_id', 'id');
    }
}
