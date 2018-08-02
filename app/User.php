<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'org_name',
        'first_name',
        'last_name',
        'user_name',
        'logo_img',
        'back_img',
        'user_role',
        'email',
        'password',
        'birth_date',
        'gender',
        'zipcode',
        'location',
        'lat',
        'lng',
        'contact_number',
        'brif',
        'website',
        'org_type',
        'remember_token',
        'forgot_status' .
        'status',
        'is_deleted'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'type_name',
        'oppr_count',
    ];

    public function getTypeNameAttribute()
    {
        if ($this->user_role == 'organization') {
            $org_type_name = Organization_type::where('id', $this->org_type)->get()->first();
            return $org_type_name->organization_type;
        } else
            return '';
    }

    public function getOpprCountAttribute()
    {
        $today = date("Y-m-d");
        $count = Opportunity::where('org_id', $this->id)->where('type', 1)->where('is_deleted', '<>', '1')->where('end_date', '>=', $today)->count();
        return $count;
    }

    public function getLoggedHoursSum()
    {
        return $this->tracksVoluntier()
                ->where('approv_status', 1)
                ->where('is_deleted', '<>', 1)
                ->sum('logged_mins') / 60;
    }

    public function getFullNameVolunteer()
    {
        return implode(' ', array_filter([$this->first_name, $this->last_name]));
    }

    public function fullLocation()
    {
        return implode(', ', array_filter([$this->city, $this->state, $this->country]));
    }

    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id', 'id');
    }

    public function whereUserFriends()
    {
        return $this->hasMany(Friend::class, 'friend_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function alertReceivers()
    {
        return $this->hasMany(Alert::class, 'receiver_id', 'id');
    }

    public function alertSenders()
    {
        return $this->hasMany(Alert::class, 'sender_id', 'id');
    }

    public function follower()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id');
    }

    public function followed()
    {
        return $this->hasMany(Follow::class, 'followed_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id');
    }

    public function MessagesWhereYouReceiver()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'id');
    }

    public function MessagesWhereYouSender()
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    public function newsFeeds()
    {
        return $this->hasMany(NewsfeedModel::class, 'who_joined', 'id');
    }

    public function opportunity()
    {
        return $this->belongsToMany(Opportunity::class, 'opportunity_members', 'user_id', 'oppor_id');
    }

    public function opportunityOrg()
    {
        return $this->belongsToMany(Opportunity::class, 'opportunity_members', 'org_id', 'oppor_id');
    }

    public function reviewFrom()
    {
        return $this->hasMany(Review::class, 'review_from', 'id');
    }

    public function reviewTo()
    {
        return $this->hasMany(Review::class, 'review_to', 'id');
    }

    public function tracksVoluntier()
    {
        return $this->hasMany(Tracking::class, 'volunteer_id', 'id');
    }

    public function tracksOrganization()
    {
        return $this->hasMany(Tracking::class, 'org_id', 'id');
    }
}
