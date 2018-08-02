<?php

namespace App\Http\Controllers\Volunteer;

use App\Chat;
use App\Services\ChatService;
use App\Alert;
use App\Follow;
use App\Comment;
use App\Friend;
use App\Group;
use App\Message;
use App\NewsfeedModel;
use App\Group_member;
use App\Group_member_role;
use App\Opportunity;
use App\Opportunity_member;
use App\Review;
use App\Tracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Image;
use App\Services\NewsFeedService;
use App\Services\OrganizationViewProfileService as viewService;
use Illuminate\Database\Eloquent\Builder;
use App\Services\ChatManager;
use App\Services\ImageExif;

class HomeCtrl extends Controller
{

    public function viewHome(Request $request, NewsFeedService $newsFeedService)
    {
        $user = Auth::user();

        $getAllFrndId = Friend::where('user_id', $user->id)->where('status', 2)->pluck('friend_id')->toArray();
        $newsFeedData = NewsfeedModel::whereIn('who_joined', $getAllFrndId)->orderBy('created_at', 'desc')->paginate(15);

        $feedNewsArr = array();

        if (!empty($newsFeedData[0])) {
            $feedNewsArr = $newsFeedService->transformNewsFeedToArrayInfo($newsFeedData, 'volunteer');
        }

        $lastOrganitationData = User::where('user_role', 'organization')->orderBy('id', 'desc')->limit(3)->offset(0)->get()->toArray();
        $user_city = $user->city;
        $nearestOpportunityData = Opportunity::where('city', $user_city)->orderBy('id', 'desc')->limit(5)->offset(0)->get()->toArray();

        return view('volunteer.home',
            ['feedNewsArr' => $feedNewsArr, 'lastOrgData' => $lastOrganitationData, 'nearestOpporData' => $nearestOpportunityData, 'page_name' => 'vol_home', 'newsFeedPaginate' => $newsFeedData]);
    }

    public function viewEditAccount()
    {
        return view('volunteer.accountsetting', ['page_name' => '']);
    }

    public function viewProfile($id = null)
    {
        
        $user = Auth::user();

        $keywords = Opportunity::with('users')->whereHas('users', function($query)  {
            $query->where('user_id',Auth::user()->id);
          })->get();

        if ($user->user_role == 'organization' and User::find($id)->user_role == 'volunteer') {
            $viewService = new viewService;

            return $viewService->viewProfile($id);
        }

        if ($id == null) {
            $id = $user->id;
        }

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

            $tracks = Tracking::where('volunteer_id',$user->id)->where('is_deleted','<>',1)->orderBy('updated_at','desc')->get();

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
            $comments= DB::table('comments')->where('status_user_id',$id)->get();

            
            return view('organization.profile',
                ['user' => $user, 'profile_info' => $profile_info, 'active_oppr' => $opportunities, 'tracks'=>$tracks,
                    'group' => $groups, 'friend' => $friends, 'page_name' => 'vol_profile', 'chat_id' => $chat_id, 'chat_deleted' => $deleted, 'keywords' => $keywords, 'comments'=> $comments]);
        } else {
            $profile_info = array();
            $profile_info['is_volunteer'] = 0;
            $is_followed = Follow::where('follower_id',
                Auth::user()->id)->where('followed_id', $id)->where('is_deleted',
                '<>', 1)->get()->first();
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
            $user = User::find($id);
            $tracks_hours = Tracking::where('org_id', $id)->where('approv_status',
                1)->where('is_deleted', '<>', 1)->sum('logged_mins');
            $profile_info['tracks_hours'] = $tracks_hours / 60;

            $today = date("Y-m-d");
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
            join('users', 'opportunity_members.user_id', '=', 'users.id')->select('users.*')->get();
            $members = array();
            foreach ($my_members as $m) {
                $members[$m->id] = $m;
            }

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

            return view('volunteer.profile',
                ['user' => $user, 'profile_info' => $profile_info, 'active_oppr' => $active_oppr,'group' => $groups,'members' => $members, 
                'friend' => $friends, 'page_name' => 'org_profile', 'chat_id' => $chat_id, 'chat_deleted' => $deleted]);
        }
    }

    public function viewImpact(Request $request)
    {
        $user_id = Auth::user()->id;
        $logged_hours = Tracking::where('volunteer_id', $user_id)->where('is_deleted',
            '<>', 1)->where('approv_status', 1)->sum('logged_mins');
        $logged_hours = $logged_hours / 60;

        $track_by_org = Tracking::where('volunteer_id', $user_id)->where('is_deleted',
            '<>', 1)->where('approv_status', 1)->
        groupBy('org_id')->selectRaw('org_id, sum(logged_mins)/60 as logged_hours')->get();
        $org_rank = array();
        $k = 0;
        foreach ($track_by_org as $tbo) {
            $org_rank[$k]['org_name'] = $tbo->org_name;
            $org_rank[$k]['my_hours'] = floatval($tbo->logged_hours);
            $org_rank[$k]['my_ranking'] = $this->getRanking($tbo->org_id,
                floatval($tbo->logged_hours));
            $k++;
        }

        $track_by_opp = Tracking::where('volunteer_id', $user_id)->where('is_deleted',
            '<>', 1)->where('approv_status', 1)->
        groupBy('oppor_id')->selectRaw('oppor_id, sum(logged_mins)/60 as logged_hours')->get();

        $reviews = Review::where('review_to', $user_id)->where('is_deleted',
            '<>', 1)->orderBy('updated_at', 'desc')->paginate(10);

//        dd($logged_hours, $org_rank, $reviews, $track_by_opp);
        return view('volunteer.impact',
            ['logged_mins' => $logged_hours, 'org_ranking' => $org_rank, 'reviews' => $reviews,
                'opp_hours' => $track_by_opp, 'page_name' => 'vol_impact']);
    }

    public function getRanking($org_id, $my_tracked_hours)
    {
        $get_volunteer_hours = Tracking::where('org_id', $org_id)->where('is_deleted',
            '<>', 1)->where('approv_status', 1)->groupBy('volunteer_id')->
        selectRaw('volunteer_id, sum(logged_mins)/60 as logged_hours')->get();
        $my_ranking = 1;
        foreach ($get_volunteer_hours as $gh) {
            if (floatval($gh->logged_hours) > $my_tracked_hours) {
                $my_ranking++;
            }
        }
        return $my_ranking;
    }

    public function getFriendInfo()
    {
        $user_id = Auth::user()->id;
        $my_logged_hours = Tracking::where('volunteer_id', $user_id)
            ->where('is_deleted', '<>', 1)
            ->where('approv_status', 1)
            ->sum('logged_mins');

        $my_logged_hours = $my_logged_hours / 60;

        $friends_id = Friend::where('user_id', $user_id)
            ->whereHas('friendUser', function (Builder $query) {
                $query->where('user_role','=', 'volunteer');
            })
            ->where('is_deleted', '<>', 1)
            ->where('status', 2)
            ->pluck('friend_id')
            ->toArray();

        $friends = User::whereIn('id', $friends_id)->get();

        $friends_name= [];

        foreach ($friends as $name) {
            $friends_name[] = $name->first_name . $name->org_name;
        }


        $tracked_hours = Tracking::where('is_deleted', '<>', 1)
            ->where('approv_status', 1)
            ->whereIn('volunteer_id', $friends_id)
            ->groupBy('volunteer_id')
            ->selectRaw('sum(logged_mins)/60 as logged_mins')
            ->pluck('logged_mins')
            ->toArray();

        $numeric_val = array();
        $i = 0;
        $j = 1;

        foreach ($tracked_hours as $tr) {
            $numeric_val[$i] = floatval($tr);
            $i++;

            if (floatval($tr) > $my_logged_hours) {
                $j++;
            }
        }
//        $friends_id_org = Friend::where('user_id', $user_id)
//            ->whereHas('friendUser', function (Builder $query) {
//                $query->where('user_role','=', 'organization');
//            })
//            ->where('is_deleted', '<>', 1)
//            ->where('status', 2)
//            ->pluck('friend_id')
//            ->toArray();

        $track_by_org = Tracking::where('volunteer_id', $user_id)
            ->where('is_deleted',
                '<>', 1)
//            ->whereIn('org_id', $friends_id_org)
            ->where('approv_status', 1)
            ->groupBy('org_id')
            ->selectRaw('org_id, sum(logged_mins)/60 as logged_hours')
            ->get();

        $org_hours = array();
        $k = 0;

        foreach ($track_by_org as $tbo) {
            $org_hours[$k][] = $tbo->org_name;
            $org_hours[$k][] = floatval($tbo->logged_hours);
            $k++;
        }

        return Response::json(['friend_name' => $friends_name, 'logged_hours' => $numeric_val,
            'rank' => $j, 'org_hours' => $org_hours]);
    }

    public function upload_logo(Request $request)
    {
        if ($request->hasFile('file_logo')) {
            $file = $request->file('file_logo');

            //you also need to keep file extension as well
//			'.'.$file->getClientOriginalExtension()
            $name = time() . str_replace(" ","",$file->getClientOriginalName());

            $image['filePath'] = $name;

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($file);

            if ($newFileImg) {
                $newFileImg->save(public_path() . '/uploads/' . $name);
            } else {
                $file->move(public_path() . '/uploads/', $name);
            }

            //using array instead of object

            $get_user = User::find(Auth::user()->id);
            $get_user->logo_img = $name;
            $save =  $get_user->save();

            if ($save) {
	            $allChatsUser = Chat::where('user_id', Auth::user()->id)->whereNotNull('to_user_id')->get();
	            $chatService = new ChatService();
	            $chatService->updateUserInfo($get_user);
	            if($get_user->user_role === 'organization')
		            $logo = $get_user->logo_img === null ? asset('img/org/001.png') : asset('uploads/' . $get_user->logo_img);
	            else{
		            $logo = $get_user->logo_img === null ? asset('img/logo/member-default-logo.png') : asset('uploads/' . $get_user->logo_img);
	            }
	            foreach ($allChatsUser as $chat){
		            $chatService->updateChatInfo($chat->chat_id, $get_user->user_name,  $logo);
	            }
	            $allChatsUser = Chat::where('to_user_id', $get_user->id)->get();
	            foreach ($allChatsUser as $chat){
		            $opponent = User::find($chat->user_id);
		            $chatService->updateChatInfo($chat->chat_id, $get_user->org_name, $logo, $opponent->user_name);
	            }
            }
        }
        return Redirect::back()->with('Success', 'Logo image uploaded');
    }

    public function upload_back_img(Request $request)
    {
        if ($request->hasFile('file_logo')) {
            $file = $request->file('file_logo');

            $name = time() . str_replace(" ","",$file->getClientOriginalName());

            //using array instead of object
            $image['filePath'] = $name;
            //$file->move(public_path().'/uploads/', $name);

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($file);

            $destinationPath = public_path('uploads/');

            if ($newFileImg) {
                $newFileImg->save($destinationPath . '/' . $name);
            } else {
                $imgBanner = Image::make($file->getRealPath());
                $imgBanner->save($destinationPath . '/' . $name);
                $imgBanner->crop(1500, 300)->save($destinationPath . '/' . $name);
            }

            $get_user = User::find(Auth::user()->id);
            $get_user->back_img = $name;
            $get_user->save();
        }
        return Redirect::back()->with('Success', 'Back image uploaded');
    }

    public function getAddress(Request $request)
    {
        $ip = $request->ip();
        $details = json_decode(file_get_contents("http://ipinfo.io/" . $ip . "/json"),
            true);
        if (isset($details['loc'])) {
            return $details;
        } else {
            return 'error';
        }
    }

    public function Search(Request $request)
    {
        $keyword = $request->input('keyword');
        $my_id = Auth::user()->id;
        $search_filter = is_null($request->input('filter')) ? '' : $request->input('filter');
        $filerts = ['v' => 'Volunteer', 'r' => 'Organization', 'g' => 'Group', 'p' => 'Opportunities'];

        if ($search_filter == '') {
            $org_result = User::where('is_deleted', '<>', 1)->where(function ($query) use ($keyword) {
                $keyword_terms = explode(' ', $keyword);
                foreach ($keyword_terms as $terms) {
                    $query->orWhere("org_name", "LIKE", "%$terms%")
                        ->orWhere("first_name", "LIKE", "%$terms%")
                        ->orWhere("last_name", "LIKE", "%$terms%")
                        ->orWhere("brif", "LIKE", "%$terms%")
                        ->orWhere("city", "LIKE", "%$terms%")
                        ->orWhere("state", "LIKE", "%$terms%")
                        ->orWhere("ein", "LIKE", "%$terms%");
                }
            })->orderBy('created_at', 'desc')->get();
            $result = array();
            $i = 0;
            foreach ($org_result as $o) {
                if ($o->id != $my_id) {
                    $result[$i]['id'] = $o->id;
                    $result[$i]['group_id'] = 0;
                    if ($o->user_role == 'organization') {
                        $result[$i]['name'] = $o->org_name;
                    } else {
                        $result[$i]['name'] = $o->first_name . ' ' . $o->last_name;
                    }
                    $result[$i]['user_role'] = $o->user_role;
                    $result[$i]['logo_img'] = $o->logo_img;
                    $result[$i]['city'] = $o->city;
                    $result[$i]['state'] = $o->state;
                    $result[$i]['country'] = $o->country;
                    $result[$i]['show_address'] = $o->show_address;
                    $friend = Friend::where('user_id', $my_id)
                        ->where('friend_id', $o->id)
                        ->where('is_deleted', '<>', 1)
                        ->get()
                        ->first();

                    if ($friend == null) {
                        $result[$i]['is_friend'] = 0;
                    } else {
                        $result[$i]['is_friend'] = $friend->status;
                    }

                    $result[$i]['is_followed'] = Follow::where('follower_id', $my_id)
                        ->where('type', 'organization')
                        ->where('followed_id', $o->id)
                        ->where('is_deleted', '<>', 1)
                        ->count();
                    $i++;
                }
            }
            $grp_result = Group::where('is_deleted', '<>', 1)->where('is_public',
                '<>', 0)->where(function ($grp_query) use ($keyword) {
                $grp_keyword_terms = explode(' ', $keyword);
                foreach ($grp_keyword_terms as $grp_terms) {
                    $grp_query->orWhere("name", "LIKE", "%$grp_terms%");
                }
            })->orderBy('created_at', 'desc')->get();
            $j = $i;
            foreach ($grp_result as $g) {
                if ($g->id != $my_id) {
                    $result[$j]['id'] = $g->id;
                    $result[$j]['group_id'] = $g->id;
                    $result[$j]['name'] = $g->name;
                    $result[$j]['user_role'] = 'group';
                    $result[$j]['logo_img'] = $g->logo_img;
                    $result[$j]['city'] = "";
                    $result[$j]['state'] = "";
                    $result[$j]['country'] = "";
                    //$result[$i]['show_address'] = $g->show_address ;
                    //echo "User_id".$my_id;
                    //echo "Group id".$g->id;
                    $friend = Group_member::where('user_id',
                        $my_id)->where('group_id', $g->id)->where('status',
                        2)->where('is_deleted', '<>', 1)->get()->first();
                    //echo '<pre>';print_r($friend);die;
                    if ($friend == null) {
                        $result[$j]['is_friend'] = 0;
                    } else {
                        $result[$j]['is_friend'] = 1;
                    }
                    $result[$j]['is_followed'] = Follow::where('follower_id',
                        $my_id)->where('type', 'organization')->where('followed_id',
                        $g->id)->where('is_deleted', '<>', 1)->count();
                    $j++;
                }
            }
            $opportunity_result = Opportunity::where('is_deleted', '<>', 1)->where(function ($opportunity_query) use ($keyword) {
                $opportunity_keyword_terms = explode(' ', $keyword);
                foreach ($opportunity_keyword_terms as $opportunity_terms) {
                    $opportunity_query->orWhere("title", "LIKE",
                        "%$opportunity_terms%");
                }
            })->orderBy('created_at', 'desc')->get();
            $k = $j;
            foreach ($opportunity_result as $o) {
                if ($o->id != $my_id) {
                    $result[$k]['id'] = $o->id;
                    $result[$k]['group_id'] = $o->id;
                    $result[$k]['name'] = $o->title;
                    $result[$k]['user_role'] = 'opportunity';
                    $result[$k]['logo_img'] = $o->logo_img;
                    $result[$k]['city'] = $o->city;
                    $result[$k]['state'] = $o->state;
                    $result[$k]['country'] = "";
                    $friend = Group_member::where('user_id',
                        $my_id)->where('group_id', $o->id)->where('status',
                        2)->where('is_deleted', '<>', 1)->get()->first();
                    if ($friend == null) {
                        $result[$k]['is_friend'] = 0;
                    } else {
                        $result[$k]['is_friend'] = 1;
                    }
                    $result[$k]['is_followed'] = Follow::where('follower_id',
                        $my_id)->where('type', 'organization')->where('followed_id',
                        $o->id)->where('is_deleted', '<>', 1)->count();
                    $k++;
                }
            }
        } else {
            $search_filter = explode(' ', (string)$search_filter);
            $vol_result = User::where('is_deleted', '<>', 1)
                ->where('user_role', '=', 'volunteer')
                ->where(function ($query) use ($keyword) {
                    $keyword_terms = explode(' ', $keyword);
                    foreach ($keyword_terms as $terms) {
                        $query->orWhere("org_name", "LIKE", "%$terms%")
                            ->orWhere("first_name", "LIKE", "%$terms%")
                            ->orWhere("last_name", "LIKE", "%$terms%")
                            ->orWhere("brif", "LIKE", "%$terms%")
                            ->orWhere("city", "LIKE", "%$terms%")
                            ->orWhere("state", "LIKE", "%$terms%")
                            ->orWhere("ein", "LIKE", "%$terms%");
                    }
                })->orderBy('created_at', 'desc')->get();
            $result = array();
            $h = 0;
            if (in_array('v', $search_filter)) {
                foreach ($vol_result as $o) {
                    if ($o->id != $my_id) {
                        $result[$h]['id'] = $o->id;
                        $result[$h]['group_id'] = 0;
                        if ($o->user_role == 'organization') {
                            $result[$h]['name'] = $o->org_name;
                        } else {
                            $result[$h]['name'] = $o->first_name . ' ' . $o->last_name;
                        }
                        $result[$h]['user_role'] = $o->user_role;
                        $result[$h]['logo_img'] = $o->logo_img;
                        $result[$h]['city'] = $o->city;
                        $result[$h]['state'] = $o->state;
                        $result[$h]['country'] = $o->country;
                        $result[$h]['show_address'] = $o->show_address;
                        $friend = Friend::where('user_id',
                            $my_id)->where('friend_id', $o->id)->where('is_deleted',
                            '<>', 1)->get()->first();
                        if ($friend == null) {
                            $result[$h]['is_friend'] = 0;
                        } else {
                            $result[$h]['is_friend'] = $friend->status;
                        }
                        $result[$h]['is_followed'] = Follow::where('follower_id',
                            $my_id)->where('type', 'organization')->where('followed_id',
                            $o->id)->where('is_deleted', '<>', 1)->count();
                        $h++;
                    }
                }
            }
            $org_result = User::where('is_deleted', '<>', 1)
                ->where('user_role', '=', 'organization')
                ->where(function ($query) use ($keyword) {
                    $keyword_terms = explode(' ', $keyword);
                    foreach ($keyword_terms as $terms) {
                        $query->orWhere("org_name", "LIKE", "%$terms%")
                            ->orWhere("first_name", "LIKE", "%$terms%")
                            ->orWhere("last_name", "LIKE", "%$terms%")
                            ->orWhere("brif", "LIKE", "%$terms%")
                            ->orWhere("city", "LIKE", "%$terms%")
                            ->orWhere("state", "LIKE", "%$terms%")
                            ->orWhere("ein", "LIKE", "%$terms%");
                    }
                })->orderBy('created_at', 'desc')->get();
            $i = $h;
            if (in_array('r', $search_filter)) {
                foreach ($org_result as $o) {
                    if ($o->id != $my_id) {
                        $result[$i]['id'] = $o->id;
                        $result[$i]['group_id'] = 0;
                        if ($o->user_role == 'organization') {
                            $result[$i]['name'] = $o->org_name;
                        } else {
                            $result[$i]['name'] = $o->first_name . ' ' . $o->last_name;
                        }
                        $result[$i]['user_role'] = $o->user_role;
                        $result[$i]['logo_img'] = $o->logo_img;
                        $result[$i]['city'] = $o->city;
                        $result[$i]['state'] = $o->state;
                        $result[$i]['country'] = $o->country;
                        $result[$i]['show_address'] = $o->show_address;
                        $friend = Friend::where('user_id',
                            $my_id)->where('friend_id', $o->id)->where('is_deleted',
                            '<>', 1)->get()->first();
                        if ($friend == null) {
                            $result[$i]['is_friend'] = 0;
                        } else {
                            $result[$i]['is_friend'] = $friend->status;
                        }
                        $result[$i]['is_followed'] = Follow::where('follower_id',
                            $my_id)->where('type', 'organization')->where('followed_id',
                            $o->id)->where('is_deleted', '<>', 1)->count();
                        $i++;
                    }
                }
            }
            $grp_result = Group::where('is_deleted', '<>', 1)->where('is_public',
                '<>', 0)->where(function ($grp_query) use ($keyword) {
                $grp_keyword_terms = explode(' ', $keyword);
                foreach ($grp_keyword_terms as $grp_terms) {
                    $grp_query->orWhere("name", "LIKE", "%$grp_terms%");
                }
            })->orderBy('created_at', 'desc')->get();
            $j = $i;
            if (in_array('g', $search_filter)) {
                foreach ($grp_result as $g) {
                    if ($g->id != $my_id) {
                        $result[$j]['id'] = $g->id;
                        $result[$j]['group_id'] = $g->id;
                        $result[$j]['name'] = $g->name;
                        $result[$j]['user_role'] = 'group';
                        $result[$j]['logo_img'] = $g->logo_img;
                        $result[$j]['city'] = "";
                        $result[$j]['state'] = "";
                        $result[$j]['country'] = "";
                        $friend = Group_member::where('user_id',
                            $my_id)->where('group_id', $g->id)->where('status',
                            2)->where('is_deleted', '<>', 1)->get()->first();
                        if ($friend == null) {
                            $result[$j]['is_friend'] = 0;
                        } else {
                            $result[$j]['is_friend'] = 1;
                        }
                        $result[$j]['is_followed'] = Follow::where('follower_id',
                            $my_id)->where('type', 'organization')->where('followed_id',
                            $g->id)->where('is_deleted', '<>', 1)->count();
                        $j++;
                    }
                }
            }
            $opportunity_result = Opportunity::where('is_deleted', '<>', 1)->where(function ($opportunity_query) use ($keyword) {
                $opportunity_keyword_terms = explode(' ', $keyword);
                foreach ($opportunity_keyword_terms as $opportunity_terms) {
                    $opportunity_query->orWhere("title", "LIKE",
                        "%$opportunity_terms%");
                }
            })->orderBy('created_at', 'desc')->get();
            $k = $j;

            if (in_array('p', $search_filter)) {
                foreach ($opportunity_result as $o) {
                    if ($o->id != $my_id) {
                        $result[$k]['id'] = $o->id;
                        $result[$k]['group_id'] = $o->id;
                        $result[$k]['name'] = $o->title;
                        $result[$k]['user_role'] = 'opportunity';
                        $result[$k]['logo_img'] = $o->logo_img;
                        $result[$k]['city'] = $o->city;
                        $result[$k]['state'] = $o->state;
                        $result[$k]['country'] = "";
                        $friend = Group_member::where('user_id',
                            $my_id)->where('group_id', $o->id)->where('status',
                            2)->get()->first();
                        if ($friend == null) {
                            $result[$k]['is_friend'] = 0;
                        } else {
                            $result[$k]['is_friend'] = 1;
                        }
                        $result[$k]['is_followed'] = Follow::where('follower_id',
                            $my_id)->where('type', 'organization')->where('followed_id',
                            $o->id)->where('is_deleted', '<>', 1)->count();
                        $k++;
                    }
                }
            }
        }
        if ($search_filter == '') {
            $search_filter = array();
        }
//        dd($result);
        return view('organization.search',
            ['keyword' => $keyword, 'result' => $result, 'filter' => $search_filter, 'page_name' => '']);
    }

    public function followOrganization(Request $request)
    {
        $id = $request->input('id');
        $my_id = Auth::user()->id;
        $is_exist = Follow::where('follower_id', $my_id)->where('type',
            'organization')->where('followed_id', $id)->get()->first();
        if ($is_exist == null) {
            $follower = new Follow;
            $follower->follower_id = $my_id;
            $follower->type = 'organization';
            $follower->followed_id = $id;
            $follower->save();
        } else {
            $is_exist->is_deleted = 0;
            $is_exist->save();
        }

        $alert = new Alert;
        $alert->receiver_id = $id;
        $alert->sender_id = $my_id;
        $alert->sender_type = 'volunteer';
        $alert->alert_type = Alert::ALERT_FOLLOW;
        $alert->contents = ' followed you!';
        $alert->save();
        return Response::json(['result' => 'success']);
    }

    public function unfollowOrganization(Request $request)
    {
        $id = $request->input('id');
        $my_id = Auth::user()->id;
        $is_exist = Follow::where('follower_id', $my_id)->where('type',
            'organization')->where('followed_id', $id)->get()->first();
        $is_exist->is_deleted = 1;
        $is_exist->save();

        $alert = new Alert;
        $alert->receiver_id = $id;
        $alert->sender_id = $my_id;
        $alert->sender_type = 'volunteer';
        $alert->alert_type = Alert::ALERT_FOLLOW;
        $alert->contents = ' unfollowed you!';
        $alert->save();
        return Response::json(['result' => 'success']);
    }

    public function connectOrganization(Request $request)
    {
        $id = $request->input('id');
        $my_id = Auth::user()->id;
        $is_exist = Friend::where('user_id', $my_id)->where('friend_id', $id)->get()->first();
        if ($is_exist == null) {
            $mine = new Friend;
            $mine->user_id = $my_id;
            $mine->friend_id = $id;
            $mine->status = Friend::FRIEND_PENDING;
            $mine->save();

            $friend = new Friend;
            $friend->user_id = $id;
            $friend->friend_id = $my_id;
            $friend->status = Friend::FRIEND_GET_REQUEST;
            $friend->save();
        } else {
            $is_exist->status = Friend::FRIEND_PENDING;
            $is_exist->is_deleted = 0;
            $is_exist->save();

            $friend = Friend::where('user_id', $id)->where('friend_id',
                $my_id)->get()->first();
            $friend->is_deleted = 0;
            $friend->status = Friend::FRIEND_GET_REQUEST;
            $friend->save();
        }
        $alert = new Alert;
        $alert->receiver_id = $id;
        $alert->sender_id = $my_id;
        $alert->sender_type = 'volunteer';
        $alert->alert_type = Alert::ALERT_CONNECT_CONFIRM_REQUEST;
        $alert->contents = ' want keep connection with you!';
        $alert->save();

        return Response::json(['result' => 'success']);
    }

    public function acceptFriend(Request $request)
    {
        $id = $request->input('id');
        $my_id = Auth::user()->id;
        $mine = Friend::where('user_id', $my_id)->where('friend_id', $id)->get()->first();
        $mine->status = Friend::FRIEND_APPROVED;
        $mine->save();

        $friend = Friend::where('user_id', $id)->where('friend_id',
            $my_id)->get()->first();
        $friend->status = Friend::FRIEND_APPROVED;
        $friend->save();

        $alert = new Alert;
        $alert->receiver_id = $id;
        $alert->sender_id = $my_id;
        $alert->sender_type = 'volunteer';
        $alert->alert_type = Alert::ALERT_ACCEPT;
        $alert->contents = ' accept connection.';
        $alert->save();

        $chatManager = new ChatManager();
        $chatManager->join($id);

        return Response::json(['result' => 'success']);
    }

    public function joinGroup(Request $request)
    {
        $group_id = $request->input('group_id');
        $group_list = Group::where('id', $group_id)->get();
        $creator_id = $group_list[0]->creator_id;
        $my_id = Auth::user()->id;
        $is_exist = Group_member::where('group_id', $group_id)->where('user_id',
            $my_id)->get()->first();
        if ($is_exist == null) {
            $member = new Group_member;
            $member->group_id = $group_id;
            $member->user_id = $my_id;
            $member->role_id = Group_member_role::MEMBER;
            $member->status = Group_member::APPROVED;
            $member->save();
            $insert_id = $member->id;

            if ($insert_id) {
                $newsfeed = new NewsfeedModel;
                $newsfeed->who_joined = $my_id;
                $newsfeed->related_id = $creator_id;
                $newsfeed->table_name = 'group_members';
                $newsfeed->table_id = $insert_id;
                $newsfeed->reason = 'joined in a new group';
                $newsfeed->created_at = date('Y-m-d H:i:s');
                $newsfeed->updated_at = date('Y-m-d H:i:s');
                $newsfeed->save();
            }
        } else {
            $is_exist->is_deleted = 0;
            $is_exist->status = Group_member::APPROVED;
            $is_exist->save();
        }
	    $chatManager = new ChatManager();
	    $chatManager->joinToGroup($group_id);

	    return Response::json(['result' => 'success']);
    }

    public function sendMessage(Request $request)
    {
        $sender_id = Auth::user()->id;
        $msg = new Message;
        if ($sender_id != null) {
            $msg->receiver_id = $request->input('receiver_id');
            $msg->content = $request->input('content');
            $msg->sender_id = $sender_id;
            $msg->created_at = date('Y-m-d H:i:s');
            $msg->updated_at = date('Y-m-d H:i:s');

            $save = $msg->save();
            if ($save) {
                $returnArr = array('status' => '1', 'msg' => 'Message send successfully!');
            } else {
                $returnArr = array('status' => '0', 'msg' => 'Faliure');
            }
            echo json_encode($returnArr);
            die();
        }
    }

    public function statusComment(Request $request)
    {
        $sender_id = Auth::user()->id;
        $sender_name = Auth::user()->user_name;
        
        $comment= new Comment();
        $comment->commenter_id= $sender_id;
        $comment->commenter_name= $sender_name;
        $comment->body= $request->input('comment');
        $comment->post_status= $request->input('status');
        $comment->status_user_id=$request->input('friend_id');
        $comment->save();

        return redirect('/volunteer/profile');
    }
}