<?php

namespace App\Http\Controllers\Organization;

use App\Chat;
use App\Services\ChatManager;
use App\Opportunity;
use App\Opportunity_category;
use App\NewsfeedModel;
use App\Opportunity_member;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;
use App\Http\Controllers\Controller;
use App\News;
use App\User;
use App\CommonModel;
use Illuminate\Support\Facades\DB;
use App\Services\ImageExif;

class OpportunityCtrl extends Controller
{
    public function viewPostingPage()
    {
        return view('organization.post_opportunity', ['user_info' => Auth::user(), 'opportunity_category' => Opportunity_category::all(), 'page_name' => '']);
    }

    public function viewUpdatingPage($id = null)
    {
        if ($id != null) {
            $exist_oppr = Opportunity::find($id);
            return view('organization.update_opportunity', ['oppr_info' => $exist_oppr, 'opportunity_category' => Opportunity_category::all(), 'user_info' => Auth::user(), 'page_name' => '']);
        } else {
            return view('organization.post_opportunity', ['user_info' => Auth::user(), 'opportunity_category' => Opportunity_category::all(), 'page_name' => '']);
        }
    }

    public function viewManageOpportunity()
    {
        $today = date("Y-m-d");
        $active_oppr = Opportunity::where('org_id', Auth::user()->id)->where('type', 1)->where('is_deleted', '<>', 1)->where('end_date', '>=', $today)->orderBy('created_at', 'desc')->get();
        $expired_oppr = Opportunity::where('org_id', Auth::user()->id)->where('type', 1)->where('is_deleted', '<>', 1)->where('end_date', '<', $today)->orderBy('created_at', 'desc')->get();
        return view('organization.opportunity', ['active_oppors' => $active_oppr, 'expired_oppors' => $expired_oppr, 'user_info' => Auth::user(), 'page_name' => 'org_oppor']);
    }

    public function viewOpportunity($id)
    {
        $oppr = Opportunity::find($id);
        return view('organization.viewOpportunity', ['oppr_info' => $oppr, 'user_info' => Auth::user(), 'page_name' => '']);
    }

    public function postOpportunity(Request $request)
    {
        $opportunity = new Opportunity;
        $opportunity->org_id = Auth::user()->id;
        $opportunity->org_type = Auth::user()->org_type;
        $opportunity->title = $request->get('title');
        $opportunity->category_id = $request->get('opportunity_type');
        $opportunity->description = $request->get('description');
        $opportunity->min_age = $request->get('min_age');
        $opportunity->activity = $request->get('activity');
        $opportunity->qualification = $request->get('qualification');
        $opportunity->street_addr1 = $request->get('street1');
        $opportunity->street_addr2 = $request->get('street2');
        $opportunity->city = $request->get('city');
        $opportunity->state = $request->get('state');
        $opportunity->zipcode = $request->get('zipcode');
        $opportunity->additional_info = $request->get('add_info');
        $opportunity->start_date = date("Y-m-d", strtotime($request->get('start_date')));
        $opportunity->end_date = date("Y-m-d", strtotime($request->get('end_date')));
        $opportunity->start_at = $request->get('start_at');
        $opportunity->end_at = $request->get('end_at');
        $opportunity->weekdays = $request->get('weekday_vals');
        $opportunity->contact_name = $request->get('contact_name');
        $opportunity->contact_email = $request->get('contact_email');
        $opportunity->contact_number = $request->get('contact_phone');
        $opportunity->is_deleted = 0;
        $location = $this->getLocation($request->get('street1') . ', ' . $request->get('city') . ', ' . $request->get('state'));
        if ($location != 'error') {
            $opportunity->lat = $location['lat'];
            $opportunity->lng = $location['lng'];
        }

	    $photo = asset('img/org/001.png');

        if ($request->hasFile('file_logo')) {
            $file = $request->file('file_logo');
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
            $opportunity->logo_img = $name;
            $photo = asset('uploads/' . $name);
        }
        $opportunity->save();

        $chat_service = new ChatService();
        $chatId = $chat_service->createChat($opportunity->title, $photo);
        $chat_service->addUserToChat(Auth::user(), $chatId, $opportunity->title, 'organizations');
        $chat = new Chat();
        $chat->chat_id = $chatId;
        $chat->user_id = Auth::user()->id;
        $chat->group_id = $opportunity->id;
        $chat->type = 'organizations';
        $chat->save();

        $insert_id = $opportunity->id;
        if ($insert_id) {
            $newsfeed = new NewsfeedModel;
            $newsfeed->who_joined = Auth::user()->id;
            $newsfeed->related_id = 0;
            $newsfeed->table_name = 'opportunities';
            $newsfeed->table_id = $insert_id;
            $newsfeed->reason = 'added opportunity';
            $newsfeed->created_at = date('Y-m-d H:i:s');
            $newsfeed->updated_at = date('Y-m-d H:i:s');
            $newsfeed->save();
        }
//		$news = new News;
//		$news->user_id = Auth::user()->id;
//		$news->news_type = News::POSTED_NEWS;
//		$news->title = 'New Opportunity Posted!';
//		$news->save();
        return redirect()->to('/organization/view_opportunity/' . $opportunity->id);
    }

    public function updateOpportunity(Request $request, $id)
    {
        $opportunity = Opportunity::find($id);
        $opportunity->title = $request->get('title');
        $opportunity->category_id = $request->get('opportunity_type');
        $opportunity->description = $request->get('description');
        $opportunity->min_age = $request->get('min_age');
        $opportunity->activity = $request->get('activity');
        $opportunity->qualification = $request->get('qualification');
        $opportunity->street_addr1 = $request->get('street1');
        $opportunity->street_addr2 = $request->get('street2');
        $opportunity->city = $request->get('city');
        $opportunity->state = $request->get('state');
        $opportunity->zipcode = $request->get('zipcode');
        $opportunity->additional_info = $request->get('add_info');
        $opportunity->start_date = date("Y-m-d", strtotime($request->get('start_date')));
        $opportunity->end_date = date("Y-m-d", strtotime($request->get('end_date')));
        $opportunity->start_at = $request->get('start_at');
        $opportunity->end_at = $request->get('end_at');
        $opportunity->weekdays = $request->get('weekday_vals');
        $opportunity->contact_name = $request->get('contact_name');
        $opportunity->contact_email = $request->get('contact_email');
        $opportunity->contact_number = $request->get('contact_phone');

        $location = $this->getLocation($request->get('street1') . ', ' . $request->get('city') . ', ' . $request->get('state'));
        if ($location != 'error') {
            $opportunity->lat = $location['lat'];
            $opportunity->lng = $location['lng'];
        }
        $photo = asset('img/org/001.png');
        if ($request->hasFile('file_logo')) {
            $file = $request->file('file_logo');
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

           
            $opportunity->logo_img = $name;
            $photo = asset('uploads/' . $opportunity->logo_img);
        }
        $opportunity->save();
        $opp_chat = Chat::where('group_id', $opportunity->id)->first();
        $manager = new ChatManager();
        if($opp_chat == null)
        {
            $chat_service = new ChatService();
            $chatId       = $chat_service->createChat( $opportunity->title, $photo );
            $chat_service->addUserToChat( Auth::user(), $chatId, $opportunity->title, 'organizations' );
            $chat           = new Chat();
            $chat->chat_id  = $chatId;
            $chat->user_id  = Auth::user()->id;
            $chat->group_id = $opportunity->id;
            $chat->type     = 'organizations';
            $chat->save();
        }
        $members = Opportunity_member::where('oppor_id', $opportunity->id)->get();
        foreach($members as $m)
        {
            $vol = User::find($m->user_id);
            if($vol != null)
            {
                $manager->joinOrganization( $vol, $opportunity );
            }
        }
        return redirect()->to('/organization/view_opportunity/' . $id);
    }

    public function deleteOpportunity(Request $request)
    {
        $id = $request->input('oppr_id');
        $opportunity = Opportunity::find($id);
        $opportunity->is_deleted = 1;
        $opportunity->save();
        $chat = Chat::where('group_id', $id)->first();
	    $chatManager = new ChatManager();
	    $chatService = new ChatService();
	    $vols = Opportunity_member::where('oppor_id', $id)->get();
	    foreach($vols as $vol)
	    {
	    	$u = User::find($vol->user_id);
		    $chatService->removeUserFromChat($chat->chat_id, $u->user_name, 'organizations');
	    }
	    $chatManager->deleteChat($chat);
        return Response::json(['result' => $id]);
    }

    public function getLocation($address)
    {
        /*get location from address*/
        $address = str_replace(' ', '+', $address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es";
        $result = json_decode(file_get_contents($url), true);
        if ($result['results'] == []) {
            return 'error';
        } else
            return $result['results'][0]['geometry']['location'];
    }

    public function impactPage()
    {
        $session = Auth::guard('web')->user();
        $userDetails = CommonModel::getAllRow('users', array(array('id', '=', $session->id)));
        $opportunityLists = CommonModel::getAll('opportunities', array(array('org_id', '=', $session->id), array('opportunities.is_deleted', '=', 0)), '', '', '', '');
        $opportunityGroupBycategory = CommonModel::getAll('opportunities', array(array('org_id', '=', $session->id), array('opportunities.is_deleted', '=', 0), array('opportunity_categories.id', '!=', 0)), array(array('opportunity_categories', 'opportunity_categories.id', 'opportunities.category_id')), '', '', 'category_id', array('name', 'COUNT' => 'opportunities.id'));
        $trackedHourOverall = CommonModel::getAll('tracked_hours', array(array('approv_status', '=', 1)), '', '', 'SUM', 'org_id', array('org_id', 'SUM' => 'logged_mins'));
        $trackedHour = CommonModel::getAll('tracked_hours', array(array('org_id', '=', $session->id), array('approv_status', '=', 1)), '', '', 'SUM', 'org_id', array('org_id', 'SUM' => 'logged_mins'));

        $opportunityList = array();
        if (count($opportunityLists) > 0) {
            foreach ($opportunityLists as $key => $value) {
                $total_hours = 0;
                $opportunityList[] = $value;
                $opportunityList[$key]->tracked_hours = 0;
                $hours = CommonModel::getAll('tracked_hours', array(array('oppor_id', '=', $value->id), array('approv_status', '=', 1)), '', 'logged_mins');
                if (count($hours) > 0) {
                    foreach ($hours as $track) {
                        $total_hours = $total_hours + $track->logged_mins;
                    }
                }
                $opportunityList[$key]->tracked_hours = $total_hours;
            }
        }
        $lastmonthFirstDay = date('Y-m-d', strtotime("first day of -1 month"));
        $lastmonthlastDay = date('Y-m-d', strtotime("last day of -1 month"));
        $lastMonth = CommonModel::getAll('tracked_hours', array(array('org_id', '=', $session->id), array('approv_status', '=', 1), array('logged_date', '>=', $lastmonthFirstDay), array('logged_date', '<=', $lastmonthlastDay)), '', '', '', 'logged_date', array('logged_date', 'SUM' => 'logged_mins'));



        $sixmonthFirstDay = date('Y-m-d', strtotime("first day of -6 month"));
        $currentDay = date('Y-m-d');
        $sixMonth = CommonModel::getAll('tracked_hours', array(array('org_id', '=', $session->id), array('approv_status', '=', 1), array('logged_date', '>=', $sixmonthFirstDay), array('logged_date', '<=', $currentDay)), '', '', '', 'MONTH', array('logged_date', 'SUM' => 'logged_mins', 'MONTH' => 'logged_date'));


        $lastYearFirstDay = date('Y-m-d', strtotime("first day of -12 month"));
        $currentDay = date('Y-m-d');
        $LastYear = CommonModel::getAll('tracked_hours', array(array('org_id', '=', $session->id), array('approv_status', '=', 1), array('logged_date', '>=', $lastYearFirstDay), array('logged_date', '<=', $currentDay)), '', '', '', 'MONTH', array('logged_date', 'SUM' => 'logged_mins', 'MONTH' => 'logged_date'));

        $currentDay = date('Y-m-d');
        $year = CommonModel::getAll('tracked_hours', array(array('org_id', '=', $session->id), array('approv_status', '=', 1), array('logged_date', '<=', $currentDay)), '', '', '', 'YEAR', array('logged_date', 'SUM' => 'logged_mins', 'YEAR' => 'logged_date'));

        $opportunityList = $this->msort($opportunityList, array('tracked_hours'));
        $rank = 0;
        if (count($trackedHour) > 0) {
            $rank = $this->myfunction($trackedHourOverall, 'org_id', $trackedHour[0]->org_id);
        }
        //echo "<pre>"; print_r($opportunityList); echo "</pre>"; die;

        //get top five and ten
        $top5_list = array();
        $top5_list['is_top5_state_lastYear'] = 0;
        $top5_list['is_top10_country_lastYear'] = 0;
        $top5_list['is_top5_state_lastMonth'] = 0;
        $top5_list['is_top10_country_lastMonth'] = 0;
        $top5_list['is_top5_state'] = 0;
        $top5_list['is_top10_country'] = 0;
        $organizer_id = $session->id;
        $country = $userDetails->country;
        $state = $userDetails->state;
        $last_year = date('Y') - 1;
        $top_5_state_year = DB::table('users')
            ->join('opportunities', 'users.id', '=', 'opportunities.org_id')
            ->join('tracked_hours', 'opportunities.id', '=', 'tracked_hours.oppor_id')
            ->where('tracked_hours.approv_status', 1)
            ->where('tracked_hours.created_at', '>=', "'" . $last_year . "-01-01'")
            ->where('tracked_hours.created_at', '<=', "'" . $last_year . "-12-31'")
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', '=', 1)
            ->where('users.state', '=', "'" . $state . "'")
            ->groupBy('tracked_hours.org_id')
            ->orderBy(DB::raw('SUM(tracked_hours.logged_mins)', 'desc'))
            ->limit(5)
            ->select('tracked_hours.org_id')
            ->get();
        $top_5_state_year = $this->create_array_fron_2D($top_5_state_year, 'org_id');
        if (in_array($organizer_id, $top_5_state_year)) {
            $top5_list['is_top5_state_lastYear'] = 1;
        }

        $top_10_country_year = DB::table('users')
            ->join('opportunities', 'users.id', '=', 'opportunities.org_id')
            ->join('tracked_hours', 'opportunities.id', '=', 'tracked_hours.oppor_id')
            ->where('tracked_hours.approv_status', 1)
            ->where('tracked_hours.created_at', '>=', "'" . $last_year . "-01-01'")
            ->where('tracked_hours.created_at', '<=', "'" . $last_year . "-12-31'")
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', '=', 1)
            ->where('users.country', '=', $country)
            ->groupBy('tracked_hours.org_id')
            ->orderBy(DB::raw('SUM(tracked_hours.logged_mins)', 'desc'))
            ->limit(10)
            ->select('tracked_hours.org_id')
            ->get();
        $top_10_country_year = $this->create_array_fron_2D($top_10_country_year, 'org_id');
        if (in_array($organizer_id, $top_10_country_year)) {
            $top5_list['is_top10_country_lastYear'] = 1;
        }

        $top_10_country_month = DB::table('users')
            ->join('opportunities', 'users.id', '=', 'opportunities.org_id')
            ->join('tracked_hours', 'opportunities.id', '=', 'tracked_hours.oppor_id')
            ->where('tracked_hours.approv_status', 1)
            ->where('tracked_hours.created_at', '>=', "'" . $lastmonthFirstDay . "'")
            ->where('tracked_hours.created_at', '<=', "'" . $lastmonthlastDay . "'")
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', '=', 1)
            ->where('users.country', '=', $country)
            ->groupBy('tracked_hours.org_id')
            ->orderBy(DB::raw('SUM(tracked_hours.logged_mins)', 'desc'))
            ->limit(10)
            ->select('tracked_hours.org_id')
            ->get();
        $top_10_country_month = $this->create_array_fron_2D($top_10_country_month, 'org_id');
        if (in_array($organizer_id, $top_10_country_month)) {
            $top5_list['is_top10_country_lastMonth'] = 1;
        }

        $top_5_state_month = DB::table('users')
            ->join('opportunities', 'users.id', '=', 'opportunities.org_id')
            ->join('tracked_hours', 'opportunities.id', '=', 'tracked_hours.oppor_id')
            ->where('tracked_hours.approv_status', 1)
            ->where('tracked_hours.created_at', '>=', "'" . $lastmonthFirstDay . "'")
            ->where('tracked_hours.created_at', '<=', "'" . $lastmonthlastDay . "'")
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', '=', 1)
            ->where('users.state', '=', $state)
            ->groupBy('tracked_hours.org_id')
            ->orderBy(DB::raw('SUM(tracked_hours.logged_mins)', 'desc'))
            ->limit(5)
            ->select('tracked_hours.org_id')
            ->get();
        $top_5_state_month = $this->create_array_fron_2D($top_5_state_month, 'org_id');
        if (in_array($organizer_id, $top_5_state_month)) {
            $top5_list['is_top5_state_lastMonth'] = 1;
        }

        $top_5_state_vol = DB::table('users')
            ->join('opportunities', 'users.id', '=', 'opportunities.org_id')
            ->join('tracked_hours', 'opportunities.id', '=', 'tracked_hours.oppor_id')
            ->where('tracked_hours.approv_status', 1)
            //->where('tracked_hours.created_at', '>=', "'".$lastmonthFirstDay."'")
            //->where('tracked_hours.created_at', '<=', "'".$lastmonthlastDay."'")
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', '=', 1)
            ->where('users.state', '=', $state)
            ->groupBy('tracked_hours.org_id')
            ->orderBy(DB::raw('COUNT(tracked_hours.logged_mins)', 'desc'))
            ->limit(5)
            ->select('tracked_hours.org_id')
            ->get();
        $top_5_state_vol = $this->create_array_fron_2D($top_5_state_vol, 'org_id');
        if (in_array($organizer_id, $top_5_state_vol)) {
            $top5_list['is_top5_state'] = 1;
        }

        $top_10_country_vol = DB::table('users')
            ->join('opportunities', 'users.id', '=', 'opportunities.org_id')
            ->join('tracked_hours', 'opportunities.id', '=', 'tracked_hours.oppor_id')
            ->where('tracked_hours.approv_status', 1)
            //->where('tracked_hours.created_at', '>=', "'".$lastmonthFirstDay."'")
            //->where('tracked_hours.created_at', '<=', "'".$lastmonthlastDay."'")
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', '=', 1)
            ->where('users.country', '=', $country)
            ->groupBy('tracked_hours.org_id')
            ->orderBy(DB::raw('COUNT(tracked_hours.logged_mins)', 'desc'))
            ->limit(10)
            ->select('tracked_hours.org_id')
            ->get();
        $top_10_country_vol = $this->create_array_fron_2D($top_10_country_vol, 'org_id');
        if (in_array($organizer_id, $top_10_country_vol)) {
            $top5_list['is_top10_country'] = 1;
        }

        return view('organization.impact', ['page_name' => 'impact'], compact('opportunityList', 'trackedHour', 'opportunityGroupBycategory', 'lastMonth', 'sixMonth', 'LastYear', 'year', 'rank', 'userDetails', 'top5_list'));
    }

    function create_array_fron_2D($array, $key)
    {
        $ret_array = array();
        if (!empty($array)) {
            foreach ($array as $val) {
                array_push($ret_array, $val->$key);
            }
        }
        return $ret_array;
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
                arsort($mapping);
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
}
