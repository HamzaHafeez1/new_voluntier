<?php

namespace App\Http\Controllers\Volunteer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Group;
use App\Group_member;
use App\Services\ChatService;
use App\Chat;
use App\NewsfeedModel;
use App\CommonModel;
use App\User;
use App\Alert;
use Validator;
use Image;
use DB;
use App\Services\ImageExif;

class GroupCtrl extends Controller
{
    public function viewGroupPage()
    {
        $session = Auth::guard('web')->user();
        $allGroupLists = CommonModel::getAll('group_members', array(array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id')), '', '', 'groups.id');
        $groupLists = CommonModel::getAll('group_members', array(array('user_id', '=', $session->id), array('group_members.status', '=', 2), array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id')), '', '', 'groups.id');

        /**********************FOR ALL GROUP***********************/

        $allGroupList = array();

        if (count($allGroupLists) > 0) {
            foreach ($allGroupLists as $keys => $values) {
                $total_hours = 0;
                $allGroupList[] = $values;
                $allGroupList[$keys]->tracked_hours = 0;
                $occations = CommonModel::getAll('group_members', array(array('group_id', '=', $values->id), array('group_members.status', '=', 2), array('group_members.is_deleted', '=', 0)), array(array('users', 'users.id', 'group_members.user_id')));

                if (count($occations) > 0) {
                    foreach ($occations as $occation) {
                        $hours = CommonModel::getAll('tracked_hours', array(array('volunteer_id', '=', $occation->user_id), array('approv_status', '=', 1)), '', 'logged_mins', '', '');
                        if (count($hours) > 0) {
                            foreach ($hours as $track) {
                                $total_hours = $total_hours + $track->logged_mins;
                            }
                        }
                    }
                }
                $allGroupList[$keys]->tracked_hours = $total_hours;
            }
        }

        $allGroupList = $this->msort($allGroupList, array('tracked_hours'));

        //echo "<pre>"; print_r($allGroupList); echo "</pre>"; die;

        /**********************FOR ALL GROUP***********************/

        $groupList = array();

        if (count($groupLists) > 0) {
            foreach ($groupLists as $key => $value) {

                $total_hours = 0;
                $groupList[] = $value;
                $groupList[$key]->members = array();
                $groupList[$key]->tracked_hours = 0;
                $groupList[$key]->datewise = array();
                $groupList[$key]->sixmonthwise = array();
                $groupList[$key]->lastYearwise = array();
                $groupList[$key]->Yearwise = array();
                $groupList[$key]->CountryWiseCountlastMonth = array();
                $groupList[$key]->groupStateWiseCountlastMonth = array();

                $groupList[$key]->creatorDetails = CommonModel::getAllRow('users', array(array('id', '=', $value->creator_id)));

                $occations = CommonModel::getAll('group_members', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('group_members.is_deleted', '=', 0)), array(array('users', 'users.id', 'group_members.user_id'), array('reviews', 'reviews.review_to', 'users.id')), '', '', array('group_members.id'));

//                $groupList[$key]->members = $occations;

                if (count($occations) > 0) {
                    foreach ($occations as $occation) {
                        $hours = CommonModel::getAll('tracked_hours', array(array('volunteer_id', '=', $occation->user_id), array('approv_status', '=', 1)), '', 'logged_mins', '', '');

                        if (count($hours) > 0) {
                            $occation->impact = 0;
                            foreach ($hours as $track) {
                                $occation->impact += $track->logged_mins;
                                $total_hours = $total_hours + $track->logged_mins;
                            }
                        }
                        else{
                            $occation->impact = 0;
                        }
                        $groupList[$key]->members[] = $occation;
                    }
                }

                $groupList[$key]->tracked_hours = $total_hours;
                $rank = $this->myfunction($allGroupList, 'group_id', $groupList[$key]->group_id);
                $groupList[$key]->rank = $rank;
                $lastmonthFirstDay = date('Y-m-d', strtotime("first day of -1 month"));
                $lastmonthlastDay = date('Y-m-d', strtotime("last day of -1 month"));
                $groupList[$key]->datewise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastmonthFirstDay), array('logged_date', '<=', $lastmonthlastDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'logged_date', array('logged_date', 'SUM' => 'logged_mins'));

                $sixmonthFirstDay = date('Y-m-d', strtotime("first day of -6 month"));
                $currentDay = date('Y-m-d');
                $groupList[$key]->sixmonthwise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $sixmonthFirstDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'MONTH', array('logged_date', 'SUM' => 'logged_mins', 'MONTH' => 'logged_date'));

                $lastYearFirstDay = date('Y-m-d', strtotime("first day of -12 month"));

                $currentDay = date('Y-m-d');

                $groupList[$key]->lastYearwise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastYearFirstDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'MONTH', array('logged_date', 'SUM' => 'logged_mins', 'MONTH' => 'logged_date'));
                $currentDay = date('Y-m-d');

                $groupList[$key]->Yearwise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'YEAR', array('logged_date', 'SUM' => 'logged_mins', 'YEAR' => 'logged_date'));

                $groupList[$key]->CountryWiseCountlastMonth = $CountryWiseCountlastMonth = CommonModel::getAll('groups', array(array('country', '=', $groupList[$key]->creatorDetails->country)), array(array('users', 'users.id', 'groups.creator_id')), 'groups.id', '', '', '', 0, 10);
                $groupList[$key]->CountryWiseCountlastMonth5 = $CountryWiseCountlastMonth5 = CommonModel::getAll('groups', array(array('state', '=', $groupList[$key]->creatorDetails->state)), array(array('users', 'users.id', 'groups.creator_id')), 'groups.id', '', '', '', 0, 5);
                $groupList[$key]->arr = array();
                $groupList[$key]->month = array();
                $groupList[$key]->arr5 = array();
                $groupList[$key]->month5 = array();

                if (count($CountryWiseCountlastMonth) > 0) {
                    foreach ($CountryWiseCountlastMonth as $k => $groups) {
                        $groupList[$key]->yearly[$k]['country'] = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $groups->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastYearFirstDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', 'SUM', '', array('group_id', 'SUM' => 'logged_mins'));

                        if (count($groupList[$key]->yearly[$k]['country']) > 0) {
                            array_push($groupList[$key]->arr, $groups->id);
                        }
                        //print_r($groupList[$key]->yearly[$k]);
                        $groupList[$key]->monthly[$k]['month'] = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $groups->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastmonthlastDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', 'SUM', '', array('group_id', 'SUM' => 'logged_mins'));

                        if (count($groupList[$key]->monthly[$k]['month']) > 0) {
                            array_push($groupList[$key]->month, $groups->id);
                        }
                    }
                }

                if (count($CountryWiseCountlastMonth5) > 0) {
                    foreach ($CountryWiseCountlastMonth5 as $k => $groups) {
                        $groupList[$key]->yearly[$k]['country'] = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $groups->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastYearFirstDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', 'SUM', '', array('group_id', 'SUM' => 'logged_mins'));

                        if (count($groupList[$key]->yearly[$k]['country']) > 0) {
                            array_push($groupList[$key]->arr5, $groups->id);
                        }
                        //print_r($groupList[$key]->yearly[$k]);

                        $groupList[$key]->monthly[$k]['month'] = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $groups->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastmonthlastDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', 'SUM', '', array('group_id', 'SUM' => 'logged_mins'));

                        if (count($groupList[$key]->monthly[$k]['month']) > 0) {
                            array_push($groupList[$key]->month5, $groups->id);
                        }
                    }
                }

                $groupList[$key]->volun = array();
                $groupList[$key]->volun5 = array();
                $volunteer = CommonModel::getAll('group_members', array(array('country', '=', $groupList[$key]->creatorDetails->country), array('group_members.status', '=', 2), array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id'), array('users', 'users.id', 'group_members.user_id')), '', 'SUM', 'group_id', array('group_id', 'SUM' => 'group_id'), 0, 10);
                $volunteer5 = CommonModel::getAll('group_members', array(array('state', '=', $groupList[$key]->creatorDetails->state), array('group_members.status', '=', 2), array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id'), array('users', 'users.id', 'group_members.user_id')), '', 'SUM', 'group_id', array('group_id', 'SUM' => 'group_id'), 0, 5);

                if (count($volunteer) > 0) {
                    foreach ($volunteer as $ks => $volun) {
                        array_push($groupList[$key]->volun, $volun->group_id);
                        //print_r($groupList[$key]->yearly[$k]);
                    }

                }

                if (count($volunteer5) > 0) {
                    foreach ($volunteer as $ks => $volun) {
                        array_push($groupList[$key]->volun5, $volun->group_id);
                        //print_r($groupList[$key]->yearly[$k]);
                    }
                }
            }
            //echo "<pre>"; print_r($groupList); echo "</pre>"; die;
        }

        return view('organization.groups', ['page_name' => 'vol_group'], compact('groupList'));
    }

    function msort($array, $key, $sort_flags = SORT_REGULAR)
    {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = array();
                foreach ($array as $k => $v) {
                    $sort_key = '';

                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        // @TODO This should be fixed, now it will be sorted as string
                        foreach ($key as $key_key) {
                            $sort_key .= $v->$key_key;
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }

                arsort($mapping, $sort_flags);
                $sorted = array();

                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }

                return $sorted;
            }
        }
        return $array;
    }

    function myfunction($products, $field, $value)
    {
        foreach ($products as $key => $product) {
            if ($product->$field === $value)
                return $key + 1;
        }

        return false;
    }

    //

    public function viewGroupAddPage($id = null)
    {
        if ($id == null)
            return view('organization.create_group', ['group_id' => $id, 'page_name' => 'org_group']);
        else {
            $group = Group::find($id);
            return view('organization.create_group', ['group_id' => $id, 'group_info' => $group, 'page_name' => 'org_group']);
        }
    }

    public function createGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_logo' => 'max:5000',
            'file_banner' => 'max:5000',
        ]);

        if ($validator->fails()) {
            \Session::flash('error', 'image bigger than 5 mb');
            return redirect()->back();
        }

        $user_id = Auth::user()->id;
        $group_name = $request->get('group_name');
        $description = $request->get('description');
        $contact_name = $request->get('contact_name');
        $contact_email = $request->get('contact_email');
        $contact_phone = $request->get('contact_phone');
        $group_type = $request->get('group_type');

        $group = new Group;
        $group->creator_id = $user_id;
        $group->name = $group_name;
        $group->description = $description;
        $group->contact_name = $contact_name;
        $group->contact_email = $contact_email;
        $group->contact_phone = $contact_phone;
        $group->status = 1;
        $group->is_public = $group_type;

        if ($request->hasFile('file_logo')) {
            $file = $request->file('file_logo');
            $name = time() . str_replace(" ","",$file->getClientOriginalName());
            //using array instead of object
            $destinationPath = public_path('uploads/volunteer_group_logo/');

            //$file->move(public_path().'/uploads/volunteer_group_logo/', $name);

            /*********image resize************/

            $destinationPaththumb = public_path('uploads/volunteer_group_logo/thumb');
            $img = Image::make($file->getRealPath());

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($file);

            if ($newFileImg) {
                $img = $newFileImg;
            }

            $img->save($destinationPath . '/' . $name);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPaththumb . '/' . $name);
            $group->logo_img = $name;
        }

        if ($request->hasFile('file_banner')) {
            $fileBanner = $request->file('file_banner');
            $nameBanner = time() . $fileBanner->getClientOriginalName();

            //using array instead of object

            $destinationPathBanner = public_path('uploads/volunteer_group_banner/');

            //$file->move(public_path().'/uploads/volunteer_group_logo/', $name);

            /*********image resize************/
            $destinationPathBannerthumb = public_path('uploads/volunteer_group_banner/thumb');
            $imgBanner = Image::make($fileBanner->getRealPath());

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($fileBanner);

            if ($newFileImg) {
                $imgBanner = $newFileImg;
            }

            $imgBanner->save($destinationPathBanner . '/' . $nameBanner);
            $imgBanner->crop(1200, 280)->save($destinationPathBannerthumb . '/' . $nameBanner);
            $group->banner_image = $nameBanner;
        }

        //dd($group);
        $group->save();

        $chatService = new ChatService();
        $logo = $group->logo_img === null ? asset('img/org/001.png') : asset('uploads/volunteer_group_logo/thumb/' . $group->logo_img);
        $chatId = $chatService->createChat($group->name, $logo);
        $chatService->addUserToChat(Auth::user(), $chatId, $group->name, 'groups');
        $chat = new Chat();
        $chat->chat_id = $chatId;
        $chat->user_id = $user_id;
        $chat->group_id = $group->id;
        $chat->type = 'groups';
        $chat->save();

        $group_member = new Group_member;
        $group_member->group_id = $group->id;
        $group_member->user_id = $user_id;
        $group_member->role_id = Group::GROUP_ADMIN;
        $group_member->status = Group_member::APPROVED;
        $group_member->save();

        return redirect()->to('/volunteer/group');
    }

    public function changeGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_logo' => 'max:5000',
            'file_banner' => 'max:5000',
        ]);

        if ($validator->fails()) {
            \Session::flash('error', 'image bigger than 5 mb');
            return redirect()->back();
        }


        $group_id = $request->get('group_id');
        $group_name = $request->get('group_name');
        $description = $request->get('description');
        $contact_name = $request->get('contact_name');
        $contact_email = $request->get('contact_email');
        $contact_phone = $request->get('contact_phone');
        $is_public = $request->get('group_type');

        $group = Group::find($group_id);
        $group->name = $group_name;
        $group->description = $description;
        $group->contact_name = $contact_name;
        $group->contact_email = $contact_email;
        $group->contact_phone = $contact_phone;
        $group->is_public = $is_public;

        if ($request->hasFile('file_logo')) {

            $file = $request->file('file_logo');
            $name = time() . str_replace(" ","",$file->getClientOriginalName());

            //using array instead of object

            $destinationPath = public_path('uploads/volunteer_group_logo/');

            //$file->move(public_path().'/uploads/volunteer_group_logo/', $name);

            /*********image resize************/

            $destinationPaththumb = public_path('uploads/volunteer_group_logo/thumb');
            $img = Image::make($file->getRealPath());

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($file);

            if ($newFileImg) {
                $img = $newFileImg;
            }

            $img->save($destinationPath . '/' . $name);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPaththumb . '/' . $name);

            $group->logo_img = $name;
        }

        if ($request->hasFile('file_banner')) {
            $fileBanner = $request->file('file_banner');
            $nameBanner = time() . $fileBanner->getClientOriginalName();

            //using array instead of object

            $destinationPathBanner = public_path('uploads/volunteer_group_banner/');

            //$file->move(public_path().'/uploads/volunteer_group_logo/', $name);

            /*********image resize************/

            $destinationPathBannerthumb = public_path('uploads/volunteer_group_banner/thumb');
            $imgBanner = Image::make($fileBanner->getRealPath());

            $imageExif = new ImageExif();
            $newFileImg = $imageExif->exif($fileBanner);

            if ($newFileImg) {
                $imgBanner = $newFileImg;
            }

            $imgBanner->save($destinationPathBanner . '/' . $nameBanner);
            $imgBanner->crop(1200, 280)->save($destinationPathBannerthumb . '/' . $nameBanner);
            $group->banner_image = $nameBanner;
        }

        $group->save();

	    $chatsGroup = Chat::where('group_id', $group->id)->first();
	    $chatService = new ChatService();
	    $logo = $group->logo_img === null ? asset('img/org/001.png') : asset('uploads/volunteer_group_banner/' . $group->logo_img);
	    $chatService->updateChatInfo($chatsGroup->id, $group->name,  $logo);

        return redirect()->to('/volunteer/group');
    }

    public function getUserList(Request $req)
    {
        $keyword = $req->get('keyword');
        $groupId = $req->get('groupId');
        $getUserList = User::where('first_name', 'like', '%' . $keyword . '%')->get();

        //dd($getUserList);

        $html = '';

        if ($getUserList->count()) {
            $html .= '<div class="searchResult">

					<form action="' . url('api/volunteer/group/add_user_invitation') . '" method="post"  id="sendFrm">

						<ul>';

            foreach ($getUserList as $key => $value) {

                $html .= '		<li style="cursor:pointer" class="listUser"><input type="checkbox" name="list_user_id[]" value="' . $value->id . '">' . $value->first_name . ' ' . $value->last_name . '</li>';

            }

            $html .= csrf_field();

            $html .= '	</ul>

						<input type="hidden" name="group_id" value="' . $groupId . '">

						

						

					</form>

				</div>';

        } else {

            $html .= '<p>No records found.</p>';

        }

        echo $html;
        die;

    }

    public function addUserInvitation(Request $req)
    {
        $group_id = $req->get('group_id');
        $list_user_id = $req->get('list_user_id');
        $session = Auth::guard('web')->user();
        $last_id = 0;

        if ($list_user_id) {

            foreach ($list_user_id as $value) {

                $user_id = $value;

                if ($session->id != $value) {

                    $getUserData = User::where('id', $value)->get();

                    $groupData = Group::where('id', $group_id)->get();

                    $GroupMemberData = Group_member::where('user_id', $value)->where('group_id', $group_id)->get();

                    //echo $getUserData->user_role;die;

                    if ($GroupMemberData->count() == 0) {
                        $group_member = new Group_member;
                        $group_member->group_id = $group_id;
                        $group_member->user_id = $value;
                        $group_member->role_id = 2;
                        $group_member->status = 1;
                        $group_member->save();

                        $last_id = $group_member->id;

                        $alerts = new Alert;
                        $alerts->receiver_id = $value;
                        $alerts->sender_id = $session->id;
                        $alerts->sender_type = $getUserData[0]->user_role;
                        $alerts->alert_type = 10;
                        $alerts->contents = 'sent you an invitation to join ' . $groupData[0]->name . ' group';
                        $alerts->is_checked = 0;
                        $alerts->related_id = $last_id;
                        $alerts->save();

                    }

                }

            }

        }

        if ($last_id == 0) {
            $req->session()->flash('error', 'Already added');
        } else {
            $req->session()->flash('success', 'Successfully send');
        }

        return redirect()->to('/volunteer/group');

    }

    public function getUserByGroup(Request $request)
    {
        $keyword = trim($request->get('keyword'));
        $geroupId = trim($request->get('groupId'));

        $lists = DB::table('users')
            ->where(function ($query) use ($keyword) {
                $query->where("users.first_name", "LIKE", "%$keyword%")
                    ->orWhere("users.last_name", "LIKE", "%$keyword%")
                    ->orWhere("users.org_name", "LIKE", "%$keyword%");
            })
            ->join('group_members', 'users.id', '=', 'group_members.user_id')
            ->where('group_members.group_id', $geroupId)
            ->select('users.*')
            ->get();


        return view('organization.groupsMembersList', ['lists' => $lists]);
    }


    public function leaveGroup($groupId)
    {
        $group_list = Group::where('id', $groupId)->get();
        $creator_id = $group_list[0]->creator_id;

        $session = Auth::guard('web')->user();

        $groupmember = Group_member::where('user_id', $session->id)->where('group_id', $groupId)->get();
        $table_id = $groupmember[0]->id;

        $chat = Chat::where('group_id', $groupId)->first();

        $chatService = new ChatService();
        $chatService->removeUserFromChat($chat->chat_id, Auth::user()->user_name, 'groups');

        $GroupMemberData = Group_member::where('user_id', $session->id)->where('group_id', $groupId)->update(['is_deleted' => 1]);;
        if ($GroupMemberData) {
            $newsfeed = new NewsfeedModel;
            $newsfeed->who_joined = $session->id;
            $newsfeed->related_id = $creator_id;
            $newsfeed->table_name = 'group_members';
            $newsfeed->table_id = $table_id;
            $newsfeed->reason = 'left from a group';
            $newsfeed->created_at = date('Y-m-d H:i:s');
            $newsfeed->updated_at = date('Y-m-d H:i:s');
            $newsfeed->save();
        }

        return redirect()->to('/volunteer/group');
    }

}

