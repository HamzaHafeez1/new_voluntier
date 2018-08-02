<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\DB;
use Auth;
use Hash;
use Mail;
use Session;
use App\User;
use App\Usertemp;
use App\Group;
use App\Group_member;
use App\School_type;
use App\Organization_type;
use Image;

class Userlist extends Controller
{
	public function listing(){
		$session=Auth::guard('admin')->user();
		$userlist = User::orderBy('is_deleted', 'ASC')->get();

		return view('admin/userlist')->with('list',$userlist);
	} 

	public function pending(){
		$session=Auth::guard('admin')->user();
		$userlist = DB::table('users')->where('approval','PENDING')->orderBy('is_deleted', 'ASC')->get();
		return view('admin/userlist')->with('list',$userlist);
	} 

	public function deleting(Request $req){
		$usermodel = User::find($req->id);
		$usermodel->is_deleted = 1;		
		$usermodel->save();
		$req->session()->flash('success', 'Data successfully Deleted');

		return redirect('/admin/user-list');
	}

	public function editing(Request $req){
		$usermodel = User::find($req->id);
		$School_type = School_type::all()->pluck('id', 'school_type')->prepend('', 'Select');
		$organizationType = Organization_type::all()->pluck('id','organization_type')->prepend('', 'Select');

		return view('admin.user_edit', compact('usermodel','School_type','organizationType'));
	}

	public function editPost(Request $req){
		if(!empty($req->input())) {
			$usermodel = User::find($req->input('edit_user_id'));
			if($req->input('edit_user_role')=='organization'){
				$usermodel->user_name = $req->input('user_name');
				$usermodel->org_name = $req->input('org_name');
				$usermodel->school_type = $req->input('school_type');
				$usermodel->logo_img = $req->input('logo_img');
				$usermodel->contact_number = $req->input('contact_number');
				$usermodel->birth_date = $req->input('birth_date');
				$usermodel->ein = $req->input('ein');
				$usermodel->org_type = $req->input('org_type');
				$usermodel->nonprofit_org_type = $req->input('nonprofit_org_type');
				//$usermodel->location = $req->input('location');
				$usermodel->zipcode = $req->input('zipcode');
				$location = $this->getLocation($req->input('zipcode'));
				$address = $this->getAddress($req->input('zipcode'));

				if($location != 'error'){
					$usermodel->lat = $location['lat'];
					$usermodel->lng = $location['lng'];
				}
				if($address != 'error'){
					$usermodel->city = $address['city'];
					$usermodel->state = $address['state'];
					$usermodel->country = $address['country'];
				}

				if($req->file('logo_img')){

					/******remove previous storage image**********/	
					if (file_exists(public_path('/img/user/'. $usermodel->logo_img))) {
						unlink(public_path('/img/user/'. $usermodel->logo_img));
					}
					if (file_exists(public_path('/img/user/thumbnail/'. $usermodel->logo_img))) {
						unlink(public_path('/img/user/thumbnail/'. $usermodel->logo_img));
					}
			
					//unlink(public_path('/img/user/'. $usermodel->logo_img));
					//unlink(public_path('/img/user/thumbnail/'. $usermodel->logo_img));
					/******remove previous storage image**********/

					$image = $req->file('logo_img');			
					$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = public_path('img/user');				

					/*********image resize************/
					$destinationPaththumb = public_path('img/user/thumbnail');
					$img = Image::make($image->getRealPath());
					$img->save($destinationPath.'/'.$input['imagename']);
					$img->resize(100, 100, function ($constraint) {
					$constraint->aspectRatio();
					})->save($destinationPaththumb.'/'.$input['imagename']);

					$usermodel->logo_img = $input['imagename'];
				}
				$usermodel->brif = $req->input('brif');
			}else{
				$usermodel->user_name = $req->input('user_name');	
				$usermodel->first_name = $req->input('first_name');	
				$usermodel->last_name = $req->input('last_name');
				$usermodel->gender = $req->input('gender');
				$usermodel->birth_date  = $req->input('birth_date');
				$usermodel->contact_number = $req->input('contact_number');
				$usermodel->zipcode = $req->input('zipcode');
				$location = $this->getLocation($req->input('zipcode'));
				$address = $this->getAddress($req->input('zipcode'));

				if($location != 'error'){
					$usermodel->lat = $location['lat'];
					$usermodel->lng = $location['lng'];
				}

				if($address != 'error'){
					$usermodel->city = $address['city'];
					$usermodel->state = $address['state'];
					$usermodel->country = $address['country'];
				}

				if($req->file('logo_img')){

					/******remove previous storage image**********/					
					unlink(public_path('/img/user/'. $usermodel->logo_img));
					unlink(public_path('/img/user/thumbnail/'. $usermodel->logo_img));
					/******remove previous storage image**********/

					$image = $req->file('logo_img');			
					$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = public_path('img/user');				

					/*********image resize************/
					$destinationPaththumb = public_path('img/user/thumbnail');
					$img = Image::make($image->getRealPath());
					$img->save($destinationPath.'/'.$input['imagename']);
					$img->resize(100, 100, function ($constraint) {
					$constraint->aspectRatio();
					})->save($destinationPaththumb.'/'.$input['imagename']);

					/*********image resize************/
					$usermodel->logo_img = $input['imagename'];
				}
				$usermodel->brif = $req->input('brif');
			}
			$usermodel->location = $req->input('location');
			$usermodel->website = $req->input('website');
			$usermodel->facebook_url = $req->input('facebook_url');
			$usermodel->twitter_url = $req->input('twitter_url');
			$usermodel->linkedin_url = $req->input('linkedin_url');
			$usermodel->save();

			$req->session()->flash('success', 'Data successfully Deleted');
			return redirect('/admin/user-list');
		}
	}

	public function multipleDelete(Request $req){
		$ids = explode(',' ,$req->input('ids'));

		foreach($ids as $id){
			$usermodel = User::find($id);
			$usermodel->is_deleted = 1;		
			$usermodel->save();
		}		
		$req->session()->flash('success', 'Data successfully Deleted');
		return redirect('/admin/user-list');

	}
	public function importExportExcelORCSV(){
		return view('admin.file_import_export');
	}

	public function importFileIntoDB(Request $req){
		$i=0;
		if($req->hasFile('sample_file')){
			$path = $req->file('sample_file')->getRealPath();
			$name = $req->file('sample_file')->getClientOriginalName();
			$extension = $req->file('sample_file')->getClientOriginalExtension();
			if($extension == 'xls' || $extension == 'xlsx')
			{	
				$data = \Excel::load($path)->get();
				//
				if($data->count()){            
					
					foreach($data as $key => $val) {
						$json  = json_encode($val);
						$array = json_decode($json, true);
						//echo "<pre>"; print_r($array ); echo "</pre>"; die;
						$user = Usertemp::where('email',$array['email'])->count();
						if($user==0){
							$usermodel = new Usertemp;

							if($array['user_role']=='organization'){
								$usermodel->org_name =  $array['org_name'];							
								$usermodel->org_type =  $array['org_type'];
								$usermodel->school_type =  $array['school_type'];
								$usermodel->nonprofit_org_type =  $array['nonprofit_org_type'];
							}else{
								$usermodel->first_name =  $array['first_name'];
								$usermodel->last_name =  $array['last_name'];
								$usermodel->gender =  $array['gender']; 
							}
							$usermodel->ein =  $array['ein'];
							$usermodel->user_role =  $array['user_role'];
							$usermodel->user_name =  $array['user_name'];
							$usermodel->email =  $array['email'];
							$usermodel->birth_date =  $array['birth_date'];
							$usermodel->password =   Hash::make($array['password']);
							$usermodel->zipcode   =  $array['zipcode'];
							$usermodel->location  =  $array['location'];
							$usermodel->city      =  $array['city'];
							$usermodel->state     =  $array['state'];
							$usermodel->country   =  $array['country'];
							$usermodel->lat       =  $array['lat'];
							$usermodel->lng       =  $array['lng'];
							$usermodel->contact_number  =  $array['contact_number'];
							//$usermodel->brif  =  $array['brif'];
							//$usermodel->website  =  $array['website'];
							//$usermodel->facebook_url  =  $array['facebook_url'];
							//$usermodel->twitter_url =  $array['twitter_url'];
							//$usermodel->linkedin_url =  $array['linkedin_url'];
							//$usermodel->status =  1;
							//$usermodel->is_deleted =  0;
							

							if($usermodel->save()){
								$i++;
							}
						}
					}
				}
			}
		}
		if($i==0){
			$req->session()->flash('error', 'Data Not inserted');
			return 0;  
		}else{
			$req->session()->flash('success', 'Member successfully inserted');
			return $name;  
		}
		//return redirect('/admin/user-list');
	}
	public function showUserTemData(Request $req){
		$list = Usertemp::get();
		$grouplist = Group::get();
		$userCount = Usertemp::get()->count();
		return view('admin.showUserTemData',compact('list','userCount','grouplist'));
	}
	public function showUserTemDataPost(Request $req){
		$group = $req->input('group');
		$select_group = $req->input('select_group');
		$list = Usertemp::get();
		$userCount = Usertemp::get()->count();
		if($userCount>0)
		{
			foreach ($list as $key => $value) {
				$usermodel = new User;
				$groupmember = new Group_member;

				$json  = json_encode($value);
				$value = json_decode($json, true);
				$usermodel->org_name =  $value['org_name'];							
				$usermodel->org_type =  $value['org_type'];
				$usermodel->school_type =  $value['school_type'];
				$usermodel->nonprofit_org_type =  $value['nonprofit_org_type'];
			
				$usermodel->first_name =  $value['first_name'];
				$usermodel->last_name =  $value['last_name'];
				$usermodel->gender =  $value['gender']; 
				$usermodel->ein =  $value['ein'];
				$usermodel->user_role =  $value['user_role'];
				$usermodel->user_name =  $value['user_name'];
				$usermodel->email =  $value['email'];
				$usermodel->birth_date =  $value['birth_date'];
				$usermodel->password =   $value['password'];
				$usermodel->zipcode   =  $value['zipcode'];
				$usermodel->location  =  $value['location'];
				$usermodel->city      =  $value['city'];
				$usermodel->state     =  $value['state'];
				$usermodel->country   =  $value['country'];
				$usermodel->lat       =  $value['lat'];
				$usermodel->lng       =  $value['lng'];
				$usermodel->contact_number  =  $value['contact_number'];
				//print_r($usermodel); 
				$usermodel->save();
				$lastInsertId = $usermodel->id;
				if($group==1)
				{
					$Group_member = Group_member::where('group_id',$select_group)->where('user_id',$lastInsertId)->count();
   					if($Group_member==0){
						$groupmember->group_id = $select_group; 
					    $groupmember->user_id = $lastInsertId;
					    $groupmember->role_id = 2;
					    $groupmember->status  = 2;
					    $groupmember->created_at  = date('Y-m-d H:i:s');
					    $groupmember->updated_at  = date('Y-m-d H:i:s');
					    $groupmember->is_deleted  = 0; 
					    $groupmember->save();
					}
				}
				Usertemp::where('id',$value['id'])->delete();
			}
			return redirect('/admin/user-list');
		}
	}

	public function cancelUser(){
		Usertemp::truncate();

		return redirect('/admin/user-list');
	}

	public function getLocation($zipcode)
	{
		/*get location from zipcode*/
		$url ="https://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es";
		$result = json_decode(file_get_contents($url),true);

		if($result['results']==[]){
			return 'error';
		}else{
			return $result['results'][0]['geometry']['location'];
		}
	}

	public function getAddress($zipcode)
	{
		/*get address from zipcode*/
		$url ="https://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es";
		$json = json_decode(file_get_contents($url),true);
		$city = '';
		$state = '';
		$country = '';

		if($json['results']==[]){
			return 'error';
		}else{
			foreach ($json['results'] as $result) {
				foreach($result['address_components'] as $addressPart) {
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
	}

	public function approve(Request $req)
	{
		$usermodel = User::find($req->input('edit_user_id'));
		$email=$usermodel->email;
		$usermodel->first_name= $usermodel->temp_first_name;
		$usermodel->last_name= $usermodel->temp_last_name;
		$usermodel->temp_first_name=NULL;
		$usermodel->temp_last_name=NULL;
		$usermodel->approval = 'APPROVED';
		$usermodel->save();
		// $data = ['message' => 'Your name request is approved!'];
		// Mail::to($email)->send(new TestEmail($data));
		return redirect('/admin/user-list');
	}

	public function reject(Request $req)
	{
		$usermodel = User::find($req->input('edit_user_id'));
		$email=$usermodel->email;
		$usermodel->temp_first_name=NULL;
		$usermodel->temp_last_name=NULL;
		$usermodel->approval = 'REJECTED';
		$usermodel->save();
		// $data = ['message' => 'Your name request is rejected. Try sometime again....!'];
		// Mail::to($email)->send(new TestEmail($data));
		return redirect('/admin/user-list');
	}

}
