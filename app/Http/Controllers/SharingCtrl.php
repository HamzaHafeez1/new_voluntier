<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Friend;
use App\Group_member;
use App\Message;
use App\Opportunity_member;
use App\Tracking;
use App\CommonModel;
use App\User;
use App\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;

class SharingCtrl extends Controller
{
    public function sharedProfilePage($id)
    {
        $user = User::find($id);
        $today = date("Y-m-d");
        if ($user->user_role == 'volunteer') {
            $user_id = $user->id;
            $logged_hours = Tracking::where('volunteer_id', $user_id)->where('is_deleted', '<>', 1)->where('approv_status', 1)->sum('logged_mins');
            $logged_hours = $logged_hours / 60;

            $today = date('Y-m-d');
            $my_opportunities = Opportunity_member::where('user_id', $user_id)->where('is_deleted', '<>', 1)->pluck('oppor_id')->toArray();
            $opportunities = Opportunity::whereIn('id', $my_opportunities)->where('type', 1)->where('is_deleted', '<>', 1)->
            where('end_date', '>', $today)->get();

            $groups = DB::table('groups')->join('group_members', 'groups.id', '=', 'group_members.group_id')->where('group_members.user_id', $user_id)->
            where('group_members.is_deleted', '<>', 1)->where('groups.is_deleted', '<>', 1)->select('groups.*', 'group_members.role_id')->get();

            $friends = DB::table('users')->join('friends', 'users.id', '=', 'friends.friend_id')->where('friends.user_id', $user_id)->
            where('friends.is_deleted', '<>', 1)->where('users.is_deleted', '<>', 1)->where('users.confirm_code', 1)->select('users.*')->get();

            return view('sharedprofile', ['user_info' => $user, 'opportunity' => $opportunities, 'group' => $groups, 'friend' => $friends, 'logged_hours' => $logged_hours, 'user_role' => 'volunteer']);
        } else {
            $tracks_hours = Tracking::where('org_id', $id)->where('approv_status', 1)->where('is_deleted', '<>', 1)->sum('logged_mins');
            $tracks_hours = $tracks_hours / 60;

            $today = date("Y-m-d");
            $active_oppr = Opportunity::where('org_id', $id)->where('type', 1)->where('is_deleted', '<>', '1')->where('end_date', '>=', $today)->orderBy('created_at', 'desc')->get();

            $groups = DB::table('groups')->join('group_members', 'groups.id', '=', 'group_members.group_id')->where('group_members.user_id', $id)->
            where('group_members.is_deleted', '<>', 1)->where('groups.is_deleted', '<>', 1)->select('groups.*', 'group_members.role_id')->get();

            $my_members = DB::table('opportunity_members')->where('opportunity_members.org_id', $id)->where('opportunity_members.is_deleted', '<>', 1)->
            join('users', 'opportunity_members.user_id', '=', 'users.id')->select('users.*')->get();
            $members = array();
            foreach ($my_members as $m) {
                $members[$m->id] = $m;
            }

            return view('sharedprofile', ['user_info' => $user, 'tracks_hours' => $tracks_hours, 'active_oppr' => $active_oppr, 'group' => $groups, 'members' => $members, 'user_role' => 'organization']);
        }
    }

    public function shareProfile(Request $request)
    {
        $user = Auth::user();
        $emails = $request->input('emails');
        $comments = $request->input('comments');
        $shr_email = explode(',', $emails);
        if ($user->user_role == 'volunteer') {
            for ($i = 0; $i < count($shr_email); $i++) {
                $email = $shr_email[$i];
                Mail::send('emails.shareProfile', ['user_type' => 1, 'info' => $user, 'content' => $comments], function ($message) use ($user, $email) {
                    $name = $user->first_name . ' ' . $user->last_name;
                    $message->from('support@myvoluntier.com', 'MyVoluntier.com');
                    $message->to($email);
                    $message->replyTo($user->email, $name);
                    $message->subject($name . ' shared profile on MyVoluntier.com');
                });
            }
        } else {
            for ($i = 0; $i < count($shr_email); $i++) {
                $email = $shr_email[$i];
                Mail::send('emails.shareProfile', ['user_type' => 0, 'info' => $user, 'content' => $comments], function ($message) use ($user, $email) {
                    $message->from('support@myvoluntier.com', 'MyVoluntier.com');
                    $message->to($email);
                    $message->replyTo($user->email, $user->org_name);
                    $message->subject($user->org_name . ' shared profile of MyVoluntier.com');
                });
            }
        }
        return Response::json(['result' => 'success']);
    }


    public function sendRequest(Request $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $org_name = $request->input('org_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $comment = $request->input('comment');

        Mail::send('emails.sendRequest', ['first_name' => $first_name, 'last_name' => $last_name, 'org_name' => $org_name, 'email' => $email, 'phone' => $phone, 'comment' => $comment], function ($message) use ($first_name, $last_name, $email) {
            $name = $first_name . ' ' . $last_name;
            $message->from('support@myvoluntier.com', $name);
            $message->to('support@myvoluntier.com');
            $message->replyTo($email, $name);
            $message->subject($name . ' sent Request');
        });
        return Response::json(['result' => 'success']);
    }

    public function getMessage(Request $request)
    {
        $result = Message::where('receiver_id', $request->input('user_id'))->where('is_read', 0)->get();
        return Response::json(['result' => $result]);
    }

    public function getAlert(Request $request)
    {
        $result = Alert::where('receiver_id', $request->input('user_id'))->where('is_checked', 0)->count();
        return Response::json(['result' => $result]);
    }

    public function viewAlertPage()
    {
        $user = Auth::user();
        $alerts = Alert::where('receiver_id', $user->id)->orderBy('created_at', 'desc')->paginate(8);

        foreach ($alerts as $a) {
            $a->is_checked = 1;
            $a->save();
        }

        $alert_contents = array();

        foreach ($alerts as $a) {
            $sender = User::find($a->sender_id);
            $alert_contents[$a->id]['sender_id'] = $a->sender_id;
            $alert_contents[$a->id]['alert_type'] = $a->alert_type;
            $alert_contents[$a->id]['contents'] = $a->contents;
            $alert_contents[$a->id]['sender_logo'] = $sender->logo_img;
            $alert_contents[$a->id]['sender_type'] = $a->sender_type;
            $alert_contents[$a->id]['related_id'] = $a->related_id;
            $alert_contents[$a->id]['is_apporved'] = $a->is_apporved;
            $alert_contents[$a->id]['status'] = 0;
            if ($a->alert_type == Alert::ALERT_CONNECT_CONFIRM_REQUEST) {
                $friend = Friend::where('user_id', $a->sender_id)->where('friend_id', $user->id)->where('is_deleted', '<>', 1)->where('status', Friend::FRIEND_APPROVED)->get()->first();
                if ($friend != null) {
                    $alert_contents[$a->id]['status'] = 1;
                }
            }
            $alert_contents[$a->id]['date'] = $a->created_at;
            if ($a->sender_type == 'volunteer') {
                $alert_contents[$a->id]['sender_name'] = $sender->first_name . ' ' . $sender->last_name;
            } elseif ($a->sender_type == 'organization') {
                $alert_contents[$a->id]['sender_name'] = $sender->org_name;
            }
        }

        return view('notification', ['alert' => $alert_contents, 'page_name' => '', 'paginate' => $alerts]);

    }

    public function shareGroup(Request $req)
    {
        $allGroupLists = CommonModel::getAll('group_members', array(array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id')), '', '', 'groups.id');
        $groupLists = CommonModel::getAll('group_members', array(array('groups.id', '=', base64_decode($req->id)), array('group_members.is_deleted', '=', 0)), array(array('groups', 'groups.id', 'group_members.group_id')), '', '', 'groups.id');
        //$groupLists = Group::where('creator_id', $session->id)->orderBy('name', 'ASC')->get();
        //echo "<pre>"; print_r($groupLists); echo "</pre>"; die;
        /**********************FOR ALL GROUP***********************/
        $rank = 0;
        $allGroupList = array();
        if (count($allGroupLists) > 0) {
            foreach ($allGroupLists as $keys => $values) {
                $total_hours = 0;
                $allGroupList[] = $values;
                $allGroupList[$keys]->tracked_hours = 0;
                $occations = CommonModel::getAll('group_members', array(array('group_id', '=', $values->id), array('group_members.status', '=', 2)), array(array('users', 'users.id', 'group_members.user_id')));
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

                $occations = CommonModel::getAll('group_members', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2)), array(array('users', 'users.id', 'group_members.user_id')));
                $groupList[$key]->members = $occations;
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
                $groupList[$key]->tracked_hours = $total_hours;
                $rank = $this->myfunction($allGroupList, 'group_id', $groupList[$key]->group_id);
                $groupList[$key]->rank = $rank;
                $lastmonthFirstDay = date('Y-m-d', strtotime("first day of -1 month"));
                $lastmonthlastDay = date('Y-m-d', strtotime("last day of -1 month"));
                $groupList[$key]->datewise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastmonthFirstDay), array('logged_date', '<=', $lastmonthlastDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'logged_date', array('logged_date', 'SUM' => 'logged_mins'));


                //dd($CountryWiseCountlastMonth);

                $sixmonthFirstDay = date('Y-m-d', strtotime("first day of -6 month"));
                $currentDay = date('Y-m-d');
                $groupList[$key]->sixmonthwise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $sixmonthFirstDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'MONTH', array('logged_date', 'SUM' => 'logged_mins', 'MONTH' => 'logged_date'));


                $lastYearFirstDay = date('Y-m-d', strtotime("first day of -12 month"));
                $currentDay = date('Y-m-d');
                $groupList[$key]->lastYearwise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '>=', $lastYearFirstDay), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'MONTH', array('logged_date', 'SUM' => 'logged_mins', 'MONTH' => 'logged_date'));

                $currentDay = date('Y-m-d');
                $groupList[$key]->Yearwise = CommonModel::getAll('tracked_hours', array(array('group_id', '=', $value->id), array('group_members.status', '=', 2), array('approv_status', '=', 1), array('logged_date', '<=', $currentDay)), array(array('group_members', 'tracked_hours.volunteer_id', 'group_members.user_id')), '', '', 'YEAR', array('logged_date', 'SUM' => 'logged_mins', 'YEAR' => 'logged_date'));

                $groupList[$key]->CountryWiseCountlastMonth = $CountryWiseCountlastMonth = CommonModel::getAll('groups', array(array('country', '=', $groupList[$key]->creatorDetails->country)), array(array('users', 'users.id', 'groups.creator_id')), 'groups.id', '', '', '', 0, 10);
                $groupList[$key]->CountryWiseCountlastMonth5 = $CountryWiseCountlastMonth5 = CommonModel::getAll('groups', array(array('country', '=', $groupList[$key]->creatorDetails->country)), array(array('users', 'users.id', 'groups.creator_id')), 'groups.id', '', '', '', 0, 5);
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
                $volunteer = CommonModel::getAll('group_members', array(array('country', '=', $groupList[$key]->creatorDetails->country), array('group_members.status', '=', 2)), array(array('groups', 'groups.id', 'group_members.group_id'), array('users', 'users.id', 'group_members.user_id')), '', 'SUM', 'group_id', array('group_id', 'SUM' => 'group_id'), 0, 10);
                $volunteer5 = CommonModel::getAll('group_members', array(array('country', '=', $groupList[$key]->creatorDetails->country), array('group_members.status', '=', 2)), array(array('groups', 'groups.id', 'group_members.group_id'), array('users', 'users.id', 'group_members.user_id')), '', 'SUM', 'group_id', array('group_id', 'SUM' => 'group_id'), 0, 5);
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
        $page = 'Share';

        //dd($groupList);
        return view('sharegroup', ['org_type_names' => \App\Organization_type::all(), 'school_type' => \App\School_type::all(), 'page' => 'home', 'groupList' => $groupList]);
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
}
