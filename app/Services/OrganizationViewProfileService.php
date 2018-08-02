<?php

namespace App\Services;

use App\Follow;
use App\Friend;
use App\Group_member;
use App\Opportunity_member;
use App\Tracking;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Opportunity;
use App\Organization_type;


class OrganizationViewProfileService
{
    public function viewProfile($id = null)
    {
        if (User::find($id)->user_role == 'volunteer') {
            $user = User::find($id);
            $logged_hours = Tracking::where('volunteer_id', $id)->where('is_deleted',
                '<>', 1)->where('approv_status', 1)->sum('logged_mins');
            $logged_hours = $logged_hours / 60;

            $today = date('Y-m-d');
            $my_opportunities = Opportunity_member::where('user_id', $id)->where('is_deleted',
                '<>', 1)->pluck('oppor_id')->toArray();
            $opportunities = Opportunity::whereIn('id', $my_opportunities)->where('type',
                1)->where('is_deleted', '<>', 1)->
            where('end_date', '>', $today)->get();

            $groups = DB::table('groups')->join('group_members', 'groups.id',
                '=', 'group_members.group_id')->where('group_members.user_id',
                $id)->
            where('group_members.is_deleted', '<>', 1)->where('group_members.status',
                Group_member::APPROVED)->where('groups.is_deleted', '<>', 1)->select('groups.*',
                'group_members.role_id')->get();

            $friends = DB::table('users')->join('friends', 'users.id', '=',
                'friends.friend_id')->where('friends.user_id', $id)->
            where('friends.is_deleted', '<>', 1)->where('friends.status',
                2)->
            where('users.is_deleted', '<>', 1)->where('users.confirm_code',
                1)->select('users.*')->get();

            $profile_info = array();
            $profile_info['is_my_profile'] = 0;
            if ($id == Auth::user()->id) {
                $profile_info['is_my_profile'] = 1;
            }
            $is_friend = Friend::where('user_id', Auth::user()->id)->where('friend_id',
                $id)->where('is_deleted', '<>', 1)->get()->first();
            if ($is_friend == null) {
                $profile_info['is_friend'] = 0;
            } else {
                $profile_info['is_friend'] = $is_friend->status;
            }
            $profile_info['is_volunteer'] = 1;
            $profile_info['logged_hours'] = $logged_hours;

	        $deleted = true;
	        $chat_id = DB::table('user_chat')->where('user_id', Auth::user()->id)->where('to_user_id', $id)->select('*')->first();
	        if($chat_id == null)
		        $chat_id = DB::table('user_chat')->where('user_id', $id)->where('to_user_id', Auth::user()->id)->select('*')->first();
	        if($chat_id != null)
	        {
		        $deleted = false;
		        if($chat_id->status == 1 && $chat_id->user_id == Auth::user()->id) $deleted = true;
		        if($chat_id->status == 2 && $chat_id->to_user_id == Auth::user()->id) $deleted = true;
		        $chat_id = $chat_id->chat_id;
	        }

            return view('organization.profile',
                ['user' => $user, 'profile_info' => $profile_info, 'active_oppr' => $opportunities,
                    'group' => $groups, 'friend' => $friends, 'page_name' => 'vol_profile', 'chat_id' => $chat_id, 'chat_deleted' => $deleted]);
        } else {
            $profile_info                  = array();
            $profile_info['is_volunteer']  = 0;
            $profile_info['is_my_profile'] = 1;
            if ($id != Auth::user()->id) {
                $profile_info['is_my_profile'] = 0;
            }
            $is_followed = Follow::where('follower_id', Auth::user()->id)->where('followed_id',
                $id)->where('is_deleted', '<>', 1)->get()->first();
            if ($is_followed == null) {
                $profile_info['is_followed'] = 0;
            } else {
                $profile_info['is_followed'] = 1;
            }
            $is_friend = Friend::where('user_id', Auth::user()->id)->where('friend_id',
                $id)->where('is_deleted', '<>', 1)->get()->first();
            if ($is_friend == null) {
                $profile_info['is_friend'] = 0;
            } else {
                $profile_info['is_friend'] = $is_friend->status;
            }
            $user                         = User::find($id);
            $tracks_hours                 = Tracking::where('org_id', $id)->where('approv_status',
                1)->where('is_deleted', '<>', 1)->sum('logged_mins');
            $profile_info['tracks_hours'] = $tracks_hours / 60;

            $today       = date("Y-m-d");
            $active_oppr = Opportunity::where('org_id', Auth::user()->id)->where('type',
                1)->where('is_deleted', '<>', '1')->where('end_date', '>=',
                $today)->orderBy('created_at', 'desc')->get();

            $groups = DB::table('groups')->join('group_members', 'groups.id',
                '=', 'group_members.group_id')->where('group_members.user_id',
                $id)->
            where('group_members.is_deleted', '<>', 1)->where('groups.is_deleted',
                '<>', 1)->select('groups.*', 'group_members.role_id')->get();

            $my_members = DB::table('opportunity_members')->where('opportunity_members.org_id',
                $id)->where('opportunity_members.is_deleted', '<>', 1)->
            join('users', 'opportunity_members.user_id', '=', 'users.id')->
                leftjoin('reviews', 'reviews.review_to', 'users.id')->select('*')->groupBy('opportunity_members.user_id')->get();
            $members    = array();

            foreach ($my_members as $m) {
                $members[$m->user_id] = $m;
            }


//dd($members);
            $friends = DB::table('users')->join('friends', 'users.id', '=',
                'friends.friend_id')->where('friends.user_id',
                Auth::user()->id)->
            where('friends.is_deleted', '<>', 1)->where('friends.status',
                2)->
            where('users.is_deleted', '<>', 1)->where('users.confirm_code',
                1)->select('users.*')->get();

            $deleted = true;
	        $chat_id = DB::table('user_chat')->where('user_id', Auth::user()->id)->where('to_user_id', $id)->select('*')->first();
	        if($chat_id == null)
	            $chat_id = DB::table('user_chat')->where('user_id', $id)->where('to_user_id', Auth::user()->id)->select('*')->first();
	        if($chat_id != null)
	        {
		        $deleted = false;
		        if($chat_id->status == 1 && $chat_id->user_id == Auth::user()->id) $deleted = true;
		        if($chat_id->status == 2 && $chat_id->to_user_id == Auth::user()->id) $deleted = true;
		        $chat_id = $chat_id->chat_id;
	        }
            return view('organization.profile',
                ['user' => $user, 'profile_info' => $profile_info, 'active_oppr' => $active_oppr,
                    'group' => $groups,
                    'members' => $members, 'friend' => $friends, 'page_name' => 'org_profile','org_type_names' => Organization_type::all(), 'chat_id' => $chat_id, 'chat_deleted' => $deleted]);
        }
    }
}
