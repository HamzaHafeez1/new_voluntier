<?php

namespace App\Http\Controllers;

use App\School_type;
use App\User;
use App\Chat;
use App\Organization_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Comments;
use App\Mail\Account;
use App\Mail\ForgotUsername;
use App\Mail\ForgotPassword;
use App\Services\ChatService;
use Auth;
use Illuminate\Support\Facades\Input;
class UserCtrl extends Controller

{
    public function showLanding(Request $request)
    {
        if (!Auth::check()) {
            return view('home', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all()]);
        } else {
            if (Auth::user()->user_role == 'volunteer') {
                //return redirect()->to('/volunteer/');
                return view('home', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all()]);
            } else {
                //return redirect()->to('/organization/');
                return view('home', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all()]);
            }
        }
    }

    public function showFeatures(Request $request)
    {
        return view('features', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all()]);
    }

    public function showPricing(Request $request)
    {
        return view('pricing', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all(), 'page' => 'pricing']);
    }

    public function showRequest(Request $request)
    {
        return view('request', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all()]);
    }

    public function terms_conditions(Request $request)
    {
        return view('termsandconditions', ['org_type_names' => Organization_type::all(), 'school_type' => School_type::all()]);
    }

    public function regVolunteer(Request $request)
    {
        $check_username = User::where('user_name', '=', $request->input('user_name'))->count();

        if ($check_username > 0)
            return Response::json(['result' => 'username exist']);
        $check_email = User::where('email', '=', $request->input('email'))->count();

        if ($check_email > 0)
            return Response::json(['result' => 'email exist']);
        $location = $this->getLocation($request->input('zipcode'));

        if ($location == 'error')
            return Response::json(['result' => 'invalid zipcode']);

        $address = $this->getAddress($request->input('zipcode'));

        if ($address == 'error') {
            return Response::json(['result' => 'invalid zipcode']);
        }

        $user = new User;
        $user->user_role = 'volunteer';
        $user->user_name = $request->input('user_name');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->birth_date = $request->input('birth_day');
        $user->gender = $request->input('gender');
        $user->contact_number = $request->input('contact_number');
        $user->zipcode = $request->input('zipcode');
        $user->confirm_code = str_random(50);

        if ($location != 'error') {
            $user->lat = $location['lat'];
            $user->lng = $location['lng'];
        }

        if ($address != 'error') {
            $user->city = $address['city'];
            $user->state = $address['state'];
            $user->country = $address['country'];
        }

        $user->status = 0;
        $user->save();

        $chatService = new ChatService();
        $chatService->createChatUser($user->user_name, $user->first_name . ' ' . $user->last_name, asset('img/logo/member-default-logo.png'));

        \Mail::to($user)->send(new Account($user));

        return Response::json(['result' => 'success']);
    }


    public function regOrganization(Request $request)
    {
        $check_username = User::where('user_name', '=', $request->input('user_name'))->count();

        if ($check_username > 0)
            return Response::json(['result' => 'username exist']);

        $check_email = User::where('email', '=', $request->input('email'))->count();

        if ($check_email > 0)
            return Response::json(['result' => 'email exist']);

        $location = $this->getLocation($request->input('zipcode'));

        if ($location == 'error')
            return Response::json(['result' => 'invalid zipcode']);

        $address = $this->getAddress($request->input('zipcode'));

        if ($address == 'error') {
            return Response::json(['result' => 'invalid zipcode']);

        }

        $user = new User;
        $user->user_role = 'organization';
        $user->user_name = $request->input('user_name');
        $user->org_name = $request->input('org_name');

        if ($address != 'error') {
            $user->city = $address['city'];
            $user->state = $address['state'];
            $user->country = $address['country'];
        }

        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->birth_date = $request->input('birth_day');
        $user->contact_number = $request->input('contact_number');
        $user->zipcode = $request->input('zipcode');
        $user->org_type = Organization_type::OTHER;

        if ($request->input('type') !== null){
            if ($request->input('type') == Organization_type::EDUCATIONAL_INSTITUTION) {
                $user->school_type = $request->input('school_type');
            }

            if ($request->input('type') == Organization_type::NONPROFIT) {
                $user->ein = $request->input('ein');
            }

            if ($request->input('type') == Organization_type::NGO_NONPROFIT) {
                $user->nonprofit_org_type = $request->input('nonprofit_org_type');
            }

        };



        $user->confirm_code = str_random(50);

        $location = $this->getLocation($request->input('zipcode'));

        if ($location != 'error') {
            $user->lat = $location['lat'];
            $user->lng = $location['lng'];
        }

        $user->save();

        $chatService = new ChatService();

        $chatService->createChatUser($user->user_name, $user->org_name, asset('img/org/001.png'));

//	    $chatId = $chatService->createChat($user->org_name, asset('front-end/img/org/001.png'));
//	    $chatService->addUserToChat($user, $chatId, $user->org_name, 'organizations');
//	    $chat = new Chat();
//	    $chat->chat_id = $chatId;
//	    $chat->user_id = $user->id;
//	    $chat->type = 'organizations';
//	    $chat->save();

        \Mail::to($user)->send(new Account($user));

        return Response::json(['result' => 'success']);
    }


    public function login(Request $request)
    {
        $username = $request->input('user_id');
        $password = $request->input('password');

        $user = User::where('email', $username)->get()->first();

        if ($user) {
            if ($user->confirm_code == '1') {
                if (Auth::attempt(['email' => $username, 'password' => $password])) {
                    if (Auth::user()->user_role == 'volunteer') {
                        return Response::json(['result' => 'volunteer']);
                    } else {
                        return Response::json(['result' => 'organization']);
                    }
                } else {
                    return Response::json(['result' => 'invalid']);
                }
            } else {
                return Response::json(['result' => 'not_confirmed']);
            }
        } else {
            return Response::json(['result' => 'invalid']);
        }
    }


    public function signout()
    {
        Auth::logout();

        return redirect()->to('/');
    }


    public function getLocation($zipcode)
    {
        /*get location from zipcode*/
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $zipcode . "&key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es";
        $result = json_decode(file_get_contents($url), true);

        if ($result['results'] == []) {
            return 'error';
        } else {
            return $result['results'][0]['geometry']['location'];
        }
        /*get location from IP address*/

//		$ip = $request->ip();

//		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"),true);

//		return $details['loc'];

    }


    public function getAddress($zipcode)
    {
        /*get address from zipcode*/
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $zipcode . "&key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es";
        $json = json_decode(file_get_contents($url), true);

        $city = '';
        $state = '';
        $country = '';

        if ($json['results'] == []) {
            return 'error';
        } else {
            foreach ($json['results'] as $result) {
                foreach ($result['address_components'] as $addressPart) {
                    if ((in_array('locality', $addressPart['types'])) && (in_array('political', $addressPart['types'])))
                        $city = $addressPart['long_name'];
                    else if ((in_array('administrative_area_level_1', $addressPart['types'])) && (in_array('political', $addressPart['types'])))
                        $state = $addressPart['short_name'];
                    else if ((in_array('country', $addressPart['types'])) && (in_array('political', $addressPart['types'])))
                        $country = $addressPart['long_name'];
                }
            }

            $address = array();

            $address['city'] = $city;
            $address['state'] = $state;
            $address['country'] = $country;

            return $address;
        }
        /*get address from IP address*/

//		$ip = $request->ip();

//		$details = json_decode(file_get_contents("http://ipinfo.io/23.247.115.83/json"),true);

//		$city = $details['city'];

//		$state = $details['region'];

//		$country = $details['country'];

//		return $city.','.$state.','.$country;

    }


    public function update_account(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user != null) {
            $user->org_name = $request->get('org_name');
            $user->email = $request->get('email');
            $user->website = $request->get('website');
            $user->birth_date = $request->get('birth_day');
            $user->org_type = $request->get('org_type');
            $user->zipcode = $request->get('zipcode');
            //$user->show_address  = $request->get('show_address');

            $location = $this->getLocation($request->get('zipcode'));

            if ($location != 'error') {
                $user->lat = $location['lat'];
                $user->lng = $location['lng'];
            }

            $address = $this->getAddress($request->input('zipcode'));

            if ($address != 'error') {

                $user->city = $address['city'];
                $user->state = $address['state'];
                $user->country = $address['country'];

            }
            $user->location = $request->get('address');
            $user->contact_number = $request->get('contact_num');

            $user->brif = $request->get('org_summary');

            if ($request->get('new_password') != '') {
                $user->password = bcrypt($request->get('new_password'));
            }

            if ($request->get('facebook_url') != '') {
                $user->facebook_url = $request->get('facebook_url');
            }

            if ($request->get('twitter_url') != '') {
                $user->twitter_url = $request->get('twitter_url');
            }

            if ($request->get('linkedin_url') != '') {
                $user->linkedin_url = $request->get('linkedin_url');
            }

            $save = $user->save();
            if ($save) {
                $returnArr = array('status' => '1', 'msg' => 'our account is successfully updated!');


                $allChatsUser = Chat::where('user_id', Auth::user()->id)->whereNotNull('to_user_id')->get();
                $userAuth = Auth::user();
	            $chatService = new ChatService();
	            $chatService->updateUserInfo($userAuth);
	            if($user->user_role === 'organization')
		            $logo = $user->logo_img === null ? asset('img/org/001.png') : asset('uploads/' . $user->logo_img);
	            else{
		            $logo = $user->logo_img === null ? asset('img/logo/member-default-logo.png') : asset('uploads/' . $user->logo_img);
	            }
	            foreach ($allChatsUser as $chat){
		            $chatService->updateChatInfo($chat->chat_id, $user->org_name,  $logo);
	            }
	            $allChatsUser = Chat::where('to_user_id', $user->id)->get();
	            foreach ($allChatsUser as $chat){
	            	$opponent = User::find($chat->user_id);
		            $chatService->updateChatInfo($chat->chat_id, $user->org_name, $logo, $opponent->user_name);
	            }

            } else {
                $returnArr = array('status' => '0', 'msg' => 'updated Faliure');
            }
            echo json_encode($returnArr);
            die();
        }
    }

    public function update_volunteer_account(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user != null) {
            // $user->first_name = $request->get('first_name');
            // $user->last_name = $request->get('last_name');
            $user->user_name = $request->get('user_id');
            $user->email = $request->get('email');
            $user->gender = $request->get('gender');
            $user->birth_date = $request->get('birth_day');
            $user->zipcode = $request->get('zipcode');
            $user->show_address = $request->get('show_address');
            $user->show_age = $request->get('show_age');

            $location = $this->getLocation($request->get('zipcode'));

            if ($location != 'error') {
                $user->lat = $location['lat'];
                $user->lng = $location['lng'];
            }

            $address = $this->getAddress($request->input('zipcode'));

            if ($address != 'error') {
                $user->city = $address['city'];
                $user->state = $address['state'];
                $user->country = $address['country'];
            }

            $user->contact_number = $request->get('contact_num');
            $user->brif = $request->get('my_summary');

            if ($request->get('new_password') != '') {
                $user->password = bcrypt($request->get('new_password'));
            }

            $save = $user->save();
            if ($save) {
                $returnArr = array('status' => '1', 'msg' => 'Your account is successfully updated!');


	            $allChatsUser = Chat::where('user_id', Auth::user()->id)->whereNotNull('to_user_id')->get();
	            $userAuth = Auth::user();
	            $chatService = new ChatService();
	            $chatService->updateUserInfo($userAuth);
	            if($user->user_role === 'organization')
		            $logo = $user->logo_img === null ? asset('img/org/001.png') : asset('uploads/' . $user->logo_img);
	            else{
		            $logo = $user->logo_img === null ? asset('img/logo/member-default-logo.png') : asset('uploads/' . $user->logo_img);
	            }
	            foreach ($allChatsUser as $chat){
		            $chatService->updateChatInfo($chat->chat_id, $user->getFullNameVolunteer(), $logo);
	            }
	            $allChatsUser = Chat::where('to_user_id', $user->id)->get();
	            foreach ($allChatsUser as $chat){
		            $opponent = User::find($chat->user_id);
		            $chatService->updateChatInfo($chat->chat_id, $user->org_name, $logo, $opponent->user_name);
	            }
            } else {
                $returnArr = array('status' => '0', 'msg' => 'update failed');
            }
            echo json_encode($returnArr);
            die();
        }
        /* return Redirect::back()->with('Success', 'Your account is successfully updated!'); */
    }

    public function confirmAccount($user_name, $token)
    {
        $user = User::where('user_name', $user_name)->where('confirm_code', $token)->get()->first();

        if ($user) {
            $user->confirm_code = '1';
            $user->save();

            Auth::login($user);

            if (Auth::user()->user_role == 'volunteer') {
                return Redirect()->to('/volunteer');
            } else {
                return Redirect()->to('/organization');
            }

        } else {
            return Redirect()->to('/');
        }
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->get()->first();

        if ($user) {
            $user->forgot_status = str_random(50);
            $user->save();
            \Mail::to($user)->send(new ForgotPassword($user));
            return Response::json(['result' => 'success']);
        } else {
            return Response::json(['result' => 'email_not_exist']);
        }
    }

    public function forgotUsername(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->get()->first();

        if ($user) {
            \Mail::to($user)->send(new ForgotUsername($user));
            return Response::json(['result' => 'success']);
        } else {
            return Response::json(['result' => 'email_not_exist']);
        }
    }

    public function changeForgotPassword($user_name, $token)
    {
        $user = User::where('user_name', $user_name)->where('forgot_status', $token)->get()->first();

        if ($user) {
            return view('changepassword', ['id' => $user->id]);
        } else {
            return Redirect()->to('/');
        }
    }

    public function createNewPassword(Request $request)
    {
        $user_id = $request->get('user_id');
        $password = $request->get('new_password');
        $user = User::find($user_id);
        $user->password = bcrypt($password);
        $user->forgot_status = '';
        $user->save();

        Auth::login($user);

        return Redirect()->to('/');
    }

    public function updateName(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if(Input::hasFile('image'))
        {
            $file=Input::file('image');
            $file->move(public_path().'/',$file->getClientOriginalName());
            $user->temp_first_name = $request->get('first_name1');
            $user->temp_last_name = $request->get('last_name1');
            $user->proof_of_identity = $file->getClientOriginalName();
            $user->approval = 'PENDING';
        }
        $user->save();
        return redirect('volunteer/profile');
    }

    public function statusPost(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->post_status = $request->get('comment');
        $user->selection = $request->get('select');
        $user->save();
        return redirect('volunteer/profile');
    }

    public function statusDelete(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->post_status =NULL;
        $user->selection =NULL;
        $comments=DB::table('comments')->where('status_user_id',$user->id)->delete();
        $user->save();
        return redirect('volunteer/profile');
    }
}
