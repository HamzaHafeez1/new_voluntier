<?php

namespace App\Http\Controllers\Organization;

use App\Chat;
use App\Alert;
use App\Follow;
use App\Friend;
use App\Group;
use App\Message;
use App\Group_member;
use App\Group_member_role;
use App\Opportunity_member;
use App\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Opportunity;
use App\Organization_type;
use Illuminate\Support\Facades\Redirect;
use Image;
use App\NewsfeedModel;
use App\Services\NewsFeedService;
use App\Services\OrganizationViewProfileService as viewService;
use App\Services\ChatManager;
use App\Services\ChatService;
use App\Services\ImageExif;

class HomeCtrl extends Controller
{
    public function viewHome(NewsFeedService $newsFeedService)
    {
        $user = Auth::user();

        $org_id = $user->id;

        $tracks_hours = Tracking::where('org_id', $org_id)
                ->where('approv_status', 1)
                ->where('is_deleted', '<>', 1)
                ->sum('logged_mins') / 60;

        $regional_organizations = User::where('user_role', 'organization')
            ->where('confirm_code', 1)
            ->where('is_deleted', '<>', 1)
            ->where("state", "like", "%$user->state%")
            ->where("city", "like", "%$$user->city%")
            ->pluck('id')
            ->toArray();

        $org_tracks = Tracking::where('is_deleted', '<>', 1)
            ->where('approv_status', 1)
            ->whereIn('org_id', $regional_organizations)
            ->groupBy('org_id')
            ->selectRaw('sum(logged_mins)/60 as logged_mins')
            ->pluck('logged_mins')
            ->toArray();

        $i = 1;

        foreach ($org_tracks as $ot) {
            if (floatval($ot) > $tracks_hours) {
                $i++;
            }
        }


        $follow_data = Follow::where('follower_id', $org_id)
            ->where('is_deleted', '<>', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        $follows = array();

        foreach ($follow_data as $f) {
            $follows[$f->id]['id'] = $f->followed_id;
            $follows[$f->id]['type'] = $f->type;

            $followerUser = $f->user;
            if ($f->type == 'organization') {
                $follows[$f->id]['name'] = $followerUser->org_name;
                $follows[$f->id]['logo'] = $followerUser->logo_img;

                $follows[$f->id]['logged_hours'] = Tracking::where('org_id', $f->followed_id)
                        ->where('approv_status', 1)
                        ->where('is_deleted', '<>', 1)
                        ->sum('logged_mins') / 60;


            } else {
                $follows[$f->id]['name'] = $followerUser->name;
                $follows[$f->id]['logo'] = $followerUser->logo_img;
                $member_ids = Group_member::where('group_id', $f->followed_id)
                    ->where('status', Group_member::APPROVED)
                    ->where('is_deleted', '<>', 1)
                    ->pluck('user_id')
                    ->toArray();

                $follows[$f->id]['logged_hours'] = Tracking::whereIn('volunteer_id', $member_ids)
                        ->where('is_deleted', '<>', 1)
                        ->where('approv_status', 1)
                        ->sum('logged_mins') / 60;
            }

            $date = explode(' ', $f->updated_at);
            $follows[$f->id]['followed_date'] = $date[0];
        }

        $getAllFrndId = Friend::where('user_id', $user->id)
            ->where('status', Friend::FRIEND_APPROVED )
            ->whereHas('friendUser', function ($query) {
                $query->whereNotNull('org_type');
            })
            ->pluck('friend_id')
            ->toArray();

        $newsFeedData = NewsfeedModel::whereIn('who_joined', $getAllFrndId)
            ->orderBy('created_at', 'desc')
            ->get();

        $feedNewsArr = array();

        if (!empty($newsFeedData[0])) {
            $feedNewsArr = $newsFeedService->transformNewsFeedToArrayInfo($newsFeedData, 'organization');
        }

        return view('organization.home',
            ['logged_hours' => $tracks_hours, 'regional_ranking' => $i, 'follows' => $follows, 'feedNewsArr' => $feedNewsArr,
                'user' => auth()->user()]);
    }

    public function viewEditAccount()
    {
        return view('organization.accountsetting',
            ['page_name' => '', 'org_type_names' => Organization_type::all()]);
    }

    public function viewProfile($id = null, viewService $viewService)
    {
        if ($id == null) {
            $id = Auth::user()->id;
        }

        return $viewService->viewProfile($id);
    }

    public function upload_logo(Request $request)
    {
        if ($request->hasFile('file_logo')) {
            $file = $request->file('file_logo');

            //you also need to keep file extension as well
//			'.'.$file->getClientOriginalExtension()
            $name = time() . str_replace(" ","",$file->getClientOriginalName());

            //using array instead of object
            $image['filePath'] = $name;

            $image['filePath'] = $name;

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($file);

            if ($newFileImg) {
                $newFileImg->save(public_path() . '/uploads/' . $name);
            } else {
                $file->move(public_path() . '/uploads/', $name);
            }


            $get_user = User::find(Auth::user()->id);
            $get_user->logo_img = $name;
            $save = $get_user->save();

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
		            $chatService->updateChatInfo($chat->chat_id, $get_user->user_name,  $logo, $get_user->user_name);
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
                    $friend = Friend::where('user_id', $my_id)->where('friend_id',
                        $o->id)->where('is_deleted', '<>', 1)->get()->first();
                    if ($friend == null) {
                        $result[$i]['is_friend'] = 0;
                    } else {
                        $result[$i]['is_friend'] = $friend->status;
                    }
                    $result[$i]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                        'organization')->where('followed_id', $o->id)->where('is_deleted',
                        '<>', 1)->count();
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
                    $friend = Group_member::where('user_id', $my_id)->where('group_id',
                        $g->id)->where('status', 2)->get()->first();
                    if ($friend == null) {
                        $result[$j]['is_friend'] = 0;
                    } else {
                        $result[$j]['is_friend'] = 1;
                    }
                    $result[$j]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                        'organization')->where('followed_id', $g->id)->where('is_deleted',
                        '<>', 1)->count();
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
                    $friend = Group_member::where('user_id', $my_id)->where('group_id',
                        $o->id)->where('status', 2)->get()->first();
                    if ($friend == null) {
                        $result[$k]['is_friend'] = 0;
                    } else {
                        $result[$k]['is_friend'] = 1;
                    }
                    $result[$k]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                        'organization')->where('followed_id', $o->id)->where('is_deleted',
                        '<>', 1)->count();
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
            $i = 0;
            if (in_array('v', $search_filter)) {
                foreach ($vol_result as $o) {
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
                        $friend = Friend::where('user_id', $my_id)->where('friend_id',
                            $o->id)->where('is_deleted', '<>', 1)->get()->first();
                        if ($friend == null) {
                            $result[$i]['is_friend'] = 0;
                        } else {
                            $result[$i]['is_friend'] = $friend->status;
                        }
                        $result[$i]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                            'organization')->where('followed_id', $o->id)->where('is_deleted',
                            '<>', 1)->count();
                        $i++;
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
                        $friend = Friend::where('user_id', $my_id)->where('friend_id',
                            $o->id)->where('is_deleted', '<>', 1)->get()->first();
                        if ($friend == null) {
                            $result[$i]['is_friend'] = 0;
                        } else {
                            $result[$i]['is_friend'] = $friend->status;
                        }
                        $result[$i]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                            'organization')->where('followed_id', $o->id)->where('is_deleted',
                            '<>', 1)->count();
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
                        $friend = Group_member::where('user_id', $my_id)->where('group_id',
                            $g->id)->where('status', 2)->get()->first();
                        if ($friend == null) {
                            $result[$j]['is_friend'] = 0;
                        } else {
                            $result[$j]['is_friend'] = 1;
                        }
                        $result[$j]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                            'organization')->where('followed_id', $g->id)->where('is_deleted',
                            '<>', 1)->count();
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
                        $friend = Group_member::where('user_id', $my_id)->where('group_id',
                            $o->id)->where('status', 2)->get()->first();
                        if ($friend == null) {
                            $result[$k]['is_friend'] = 0;
                        } else {
                            $result[$k]['is_friend'] = 1;
                        }
                        $result[$k]['is_followed'] = Follow::where('follower_id', $my_id)->where('type',
                            'organization')->where('followed_id', $o->id)->where('is_deleted',
                            '<>', 1)->count();
                        $k++;
                    }
                }
            }

        }
        if ($search_filter == '') {
            $search_filter = array();
        }
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
        $alert->sender_type = 'organization';
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
        $alert->sender_type = 'organization';
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
        $alert->sender_type = 'organization';
        $alert->alert_type = Alert::ALERT_CONNECT_CONFIRM_REQUEST;
        $alert->contents = ' want keep connection with you.';
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
        $alert->sender_type = 'organization';
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

        } else {
            $is_exist->is_deleted = 1;
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
}
