<?php

namespace App\Http\Controllers\Organization;

use App\Chat;
use App\Follow;
use App\Friend;
use App\Group;
use App\Group_member;
use App\Group_member_role;
use App\Services\ChatService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\Response;
use App\CommonModel;
use App\Alert;
use Image;
use Validator;
use DB;
use App\Services\ImageExif;

class GroupCtrl extends Controller
{
    public function viewGroupPage()
    {
        $session = Auth::guard('web')->user();
        $allGroupLists = CommonModel::getAll('group_members', array(array('group_members.is_deleted', '=', 0), array('group_members.status', '=', 2)), array(array('groups', 'groups.id', 'group_members.group_id')), '', '', 'groups.id');
        $groupLists = CommonModel::getAll('group_members', array(array('user_id', '=', $session->id), array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id')), '', '', 'groups.id');


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
                        $hours = CommonModel::getAll('tracked_hours', array(array('volunteer_id', '=', $occation->user_id),
                            array('approv_status', '=', 1)), '', 'logged_mins', '', '');

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
                    }
                }

                if (count($volunteer5) > 0) {
                    foreach ($volunteer as $ks => $volun) {
                        array_push($groupList[$key]->volun5, $volun->group_id);
                    }
                }
            }
        }

        return view('organization.groups', ['page_name' => 'org_group'], compact('groupList'));
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

    public function viewGroupAddPage($id = null)
    {

        if ($id == null)
            return view('organization.create_group', ['group_id' => $id, 'page_name' => 'org_group']);

        else {
            $group = Group::find($id);

            return view('organization.create_group', ['group_id' => $id, 'group_info' => $group, 'page_name' => 'org_group']);
        }
    }

    /* public function createGroup(Request $request){

        $user_id = Auth::user()->id;

        $group_name = $request->get('group_name');

        $description = $request->get('description');

        $contact_name = $request->get('contact_name');

        $contact_email = $request->get('contact_email');

        $contact_phone = $request->get('contact_phone');



        $group = new Group;

        $group->creator_id = $user_id;

        $group->name = $group_name;

        $group->description = $description;

        $group->contact_name = $contact_name;

        $group->contact_email = $contact_email;

        $group->contact_phone = $contact_phone;

        if($request->hasFile('file_logo')) {

            $file = $request->file('file_logo');

            $name = time().$file->getClientOriginalName();



            //using array instead of object

            $image['filePath'] = $name;

            $file->move(public_path().'/uploads/', $name);

            $group->logo_img = $name;

        }



        $group->save();



        $group_member = new Group_member;

        $group_member->group_id = $group->id;

        $group_member->user_id = $user_id;

        $group_member->role_id = Group::GROUP_ADMIN;

        $group_member->status = Group_member::APPROVED;

        $group_member->save();



        return redirect()->to('/organization/group');

    } */

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

        return redirect()->to('/organization/group');
    }


    /* public function changeGroup(Request $request){

        $group_id = $request->get('group_id');

        $group_name = $request->get('group_name');

        $description = $request->get('description');

        $contact_name = $request->get('contact_name');

        $contact_email = $request->get('contact_email');

        $contact_phone = $request->get('contact_phone');



        $group = Group::find($group_id);

        $group->name = $group_name;

        $group->description = $description;

        $group->contact_name = $contact_name;

        $group->contact_email = $contact_email;

        $group->contact_phone = $contact_phone;

        if($request->hasFile('file_logo')) {

            $file = $request->file('file_logo');

            $name = time().$file->getClientOriginalName();



            //using array instead of object

            $image['filePath'] = $name;

            $file->move(public_path().'/uploads/', $name);

            $group->logo_img = $name;

        }



        $group->save();

        return redirect()->to('/organization/group');

    } */

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

        return redirect()->to('/organization/group');
    }


    public function removeGroup()
    {


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

    public function getUserList(Request $req)
    {
        $keyword = $req->get('keyword');
        $groupId = $req->get('groupId');
        $getUserList = User::where('first_name', 'like', '%' . $keyword . '%')->get();

        //dd($getUserList);

        $html = '';

        if ($getUserList->count()) {
            $html .= '<div class="searchResult">

					<form action="' . url('api/organization/group/add_user_invitation') . '" method="post" id="sendFrm">

						<ul style=" position: relative; text-align: left;">';

            foreach ($getUserList as $key => $value) {
                $html .= '		<li style="cursor:pointer; list-style-type: none;" class="listUser"><input type="checkbox" name="list_user_id[]" value="' . $value->id . '">' . $value->first_name . ' ' . $value->last_name . '</li>';
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
                    $GroupMemberData = Group_member::where('user_id', $value)->where('group_id', $group_id)->where('is_deleted', 0)->first();


                    if ($GroupMemberData === null) {
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
                    } else {
                        $checkAlert = Alert::where('receiver_id', $value)
                            ->where('sender_id', $session->id)
                            ->where('sender_type', $getUserData[0]->user_role)
                            ->where('alert_type', 10)
                            ->where('contents', 'sent you an invitation to join ' . $groupData[0]->name . ' group')
                            ->where('related_id', $GroupMemberData->id)
                            ->first();
//                        dd($checkAlert);
                        if ($checkAlert !== null) {
                            $req->session()->flash('error', 'Already send');
                            return redirect()->to('/organization/group');
                        }

                        $alerts = new Alert;
                        $alerts->receiver_id = $value;
                        $alerts->sender_id = $session->id;
                        $alerts->sender_type = $getUserData[0]->user_role;
                        $alerts->alert_type = 10;
                        $alerts->contents = 'sent you an invitation to join ' . $groupData[0]->name . ' group';
                        $alerts->is_checked = 0;
                        $alerts->related_id = $GroupMemberData->id;
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

        return redirect()->to('/organization/group');
    }

    public function viewGroupDetail($group_id)
    {
        $group_info = array();

        $group = Group::find($group_id);
        $group_info['group_id'] = $group->id;
        $my_group = Group_member::where('group_id', $group_id)->where('user_id', Auth::user()->id)->where('is_deleted', '<>', 1)->get()->first();

        if ($my_group == null) {
            $group_info['is_my_group'] = 0;
        } else {
            $group_info['is_my_group'] = $my_group->status;
        }

        $my_follow = Follow::where('follower_id', Auth::user()->id)->where('type', 'group')->where('followed_id', $group_id)->where('is_deleted', '<>', 1)->get()->first();

        if ($my_follow == null) {
            $group_info['is_followed'] = 0;
        } else {
            $group_info['is_followed'] = 1;
        }

        $group_info['group_name'] = $group->name;
        $group_info['group_logo'] = $group->logo_img;
        $group_info['group_description'] = $group->description;
        $group_info['group_contact_name'] = $group->contact_name;
        $group_info['group_contact_email'] = $group->contact_email;
        $group_info['group_contact_number'] = $group->contact_phone;
        $created_at = explode(" ", $group->created_at);
        $group_info['group_created_at'] = $created_at[0];
        $creator = User::find($group->creator_id);
        $group_info['org_id'] = $creator->id;
        $group_info['org_name'] = $creator->org_name;
        $group_info['org_logo'] = $creator->logo_img;

        $member_info = array();

        $group_members = Group_member::where('group_id', $group_id)->where('status', Group_member::APPROVED)->where('is_deleted', '<>', 1)->get();

        foreach ($group_members as $gm) {
            $member_info[$gm->id]['user_role'] = $gm->role_id;
            $member_info[$gm->id]['member_id'] = $gm->user_id;
            $member = User::find($gm->user_id);

            if ($member->user_role == 'organization') {
                $member_info[$gm->id]['member_name'] = $member->org_name;
                $member_info[$gm->id]['group'] = 'Organization';
            } else {
                $member_info[$gm->id]['member_name'] = $member->first_name . ' ' . $member->last_name;
            }

            $member_info[$gm->id]['member_logo'] = $member->logo_img;
            $member_info[$gm->id]['member_email'] = $member->email;
            $member_info[$gm->id]['member_number'] = $member->contact_number;
        }
        return view('organization.view_group_detail', ['group_info' => $group_info, 'member_info' => $member_info, 'page_name' => '']);
    }

    public function searchGroup(Request $request)
    {
        $keyword = $request->input('keyword');
        $my_id = Auth::user()->id;
        $my_group_ids = Group_member::where('user_id', $my_id)->where('status', Group_member::APPROVED)->where('is_deleted', '<>', 1)->groupBy('group_id')->selectRaw('group_id')->pluck('group_id')->toArray();

        if ($keyword == null) {
            $friend_id = Friend::where('user_id', $my_id)->where('status', Friend::FRIEND_APPROVED)->pluck('friend_id')->toArray();
            $group_ids = Group_member::whereIn('user_id', $friend_id)->where('status', Group_member::APPROVED)->groupBy('group_id')->selectRaw('group_id')->pluck('group_id')->toArray();
            $groups = Group::whereIn('id', $group_ids)->whereNotIn('id', $my_group_ids)->get();

            $result = array();
            $i = 0;

            foreach ($groups as $g) {
                $result[$i]['group_id'] = $g->id;
                $result[$i]['group_name'] = $g->name;
                $result[$i]['group_logo'] = $g->logo_img;
                $result[$i]['owner_id'] = $g->creator_id;

                if (User::find($g->creator_id)->user_role == 'organization') {
                    $result[$i]['owner_name'] = User::find($g->creator_id)->org_name;
                } else {
                    $result[$i]['owner_name'] = User::find($g->creator_id)->first_name . ' ' . User::find($g->creator_id)->last_name;
                }

                $result[$i]['members'] = Group_member::where('group_id', $g->id)->where('is_deleted', '<>', 1)->count();
                $result[$i]['is_followed'] = Follow::where('follower_id', $my_id)->where('type', 'group')->where('followed_id', $g->id)->where('is_deleted', '<>', 1)->count();
                $result[$i]['status'] = 0;
                $is_member = Group_member::where('group_id', $g->id)->where('user_id', $my_id)->where('is_deleted', '<>', 1)->get()->first();

                if ($is_member != null) {
                    $result[$i]['status'] = $is_member->status;
                }
                $i++;
            }
            return view('organization.group_search', ['groups' => $result, 'keyword' => $keyword, 'page_name' => 'org_group']);

        } else {
            $groups = Group::whereNotIn('id', $my_group_ids)->where('is_deleted', '<>', 1)->where(function ($query) use ($keyword) {
                $keyword_terms = explode(' ', $keyword);

                foreach ($keyword_terms as $terms) {
                    $query->orWhere("name", "LIKE", "%$terms%")
                        ->orWhere("description", "LIKE", "%$terms%");
                }
            })->orderBy('created_at', 'desc')->get();

            $result = array();
            $i = 0;

            foreach ($groups as $g) {
                $result[$i]['group_id'] = $g->id;
                $result[$i]['group_name'] = $g->name;
                $result[$i]['group_logo'] = $g->logo_img;
                $result[$i]['owner_id'] = $g->creator_id;

                if (User::find($g->creator_id)->user_role == 'organization') {
                    $result[$i]['owner_name'] = User::find($g->creator_id)->org_name;
                } else {
                    $result[$i]['owner_name'] = User::find($g->creator_id)->first_name . ' ' . User::find($g->creator_id)->last_name;
                }

                $result[$i]['members'] = Group_member::where('group_id', $g->id)->where('is_deleted', '<>', 1)->count();
                $result[$i]['is_followed'] = Follow::where('follower_id', $my_id)->where('type', 'group')->where('followed_id', $g->id)->where('is_deleted', '<>', 1)->count();
                $result[$i]['status'] = 0;

                $is_member = Group_member::where('group_id', $g->id)->where('user_id', $my_id)->where('is_deleted', '<>', 1)->get()->first();

                if ($is_member != null) {
                    $result[$i]['status'] = $is_member->status;
                }

                $i++;
            }

            return view('organization.group_search', ['groups' => $result, 'keyword' => $keyword, 'page_name' => 'org_group']);
        }
    }


    public function followGroup(Request $request)
    {
        $group_id = $request->input('group_id');
        $my_id = Auth::user()->id;
        $is_exist = Follow::where('follower_id', $my_id)->where('type', 'group')->where('followed_id', $group_id)->get()->first();

        if ($is_exist == null) {
            $follower = new Follow;
            $follower->follower_id = $my_id;
            $follower->type = 'group';
            $follower->followed_id = $group_id;
            $follower->save();
        } else {
            $is_exist->is_deleted = 0;
            $is_exist->save();
        }

        return Response::json(['result' => 'success']);
    }


    public function unfollowGroup(Request $request)
    {
        $group_id = $request->input('group_id');
        $my_id = Auth::user()->id;
        $is_exist = Follow::where('follower_id', $my_id)->where('type', 'group')->where('followed_id', $group_id)->get()->first();
        $is_exist->is_deleted = 1;
        $is_exist->save();

        return Response::json(['result' => 'success']);
    }


    public function jointoGroup(Request $request)
    {
        $group_id = $request->input('group_id');
        $my_id = Auth::user()->id;
        $is_exist = Group_member::where('group_id', $group_id)->where('user_id', $my_id)->get()->first();

        if ($is_exist == null) {
            $member = new Group_member;
            $member->group_id = $group_id;
            $member->user_id = $my_id;
            $member->role_id = Group_member_role::MEMBER;
            $member->status = Group_member::PENDING;
            $member->save();

            $chat = Chat::where('group_id', group_id)->first();
            $chatService = new ChatService();
            $chatService->addUserToChat(Auth::user, $chat->chat_id, 'groups');
        } else {
            $is_exist->is_deleted = 1;
            $is_exist->status = Group_member::PENDING;
            $is_exist->save();
        }
    }

    public function leaveGroup($groupId)
    {
        $session = Auth::guard('web')->user();
        Group_member::where('user_id', $session->id)->where('group_id', $groupId)->update(['is_deleted' => 1]);
        $chat = Chat::where('group_id', $groupId)->first();
        $chatService = new ChatService();
        $chatService->removeUserFromChat($chat->chat_id, Auth::user()->user_name, 'groups');

        return redirect()->to('/organization/group');
    }
}
