<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Hash;
use Session;
use App\Group;
use App\User;
use App\Group_member;
use Image;

class GroupManageController extends Controller
{
   public function listing(){
		$session=Auth::guard('admin')->user();
		if(count($session)==0){
			return redirect('/admin-login');
		}
		$userlist = Group::all();
		return view('admin/grouplist')->with('list',$userlist);
	} 
	
	public function deleting(Request $req){
		$groupmodel = Group::find($req->id);
		$groupmodel->is_deleted = 1;		
		$groupmodel->save();
		$req->session()->flash('success', 'Group successfully Deleted');
		return redirect('/admin/group-list');
		
	}
	public function editing(Request $req){
		$groupmodel = Group::find($req->id);
		return view('admin/group_edit')->with('userdetails',$groupmodel);
	}
	
	public function editPost(Request $req){
		if(!empty($req->input())) {
			$groupmodel = Group::find($req->input('edit_group_id'));
			
				$groupmodel->name = $req->input('grp_name');	
				$groupmodel->contact_name = $req->input('admin_name');
				$groupmodel->contact_email = $req->input('admin_email');
				$groupmodel->created_at  = $req->input('date_created');
				$groupmodel->description  = $req->input('description');
				if($req->file('logo_img')){

					/******remove previous storage image**********/					
					//unlink(public_path('/img/group/'. $groupmodel->logo_img));
					//unlink(public_path('/img/group/thumbnail/'. $groupmodel->logo_img));
					/******remove previous storage image**********/

				    $image = $req->file('logo_img');			
					$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = public_path('uploads/volunteer_group_logo/');				

					/*********image resize************/
					$destinationPaththumb = public_path('uploads/volunteer_group_logo/thumb');
					$img = Image::make($image->getRealPath());
					$img->save($destinationPath.'/'.$input['imagename']);
					$img->resize(100, 100, function ($constraint) {
					$constraint->aspectRatio();
					})->save($destinationPaththumb.'/'.$input['imagename']);

					$groupmodel->logo_img = $input['imagename'];
		   		}
		   		if($req->file('file_banner')){

					/******remove previous storage image**********/					
					//unlink(public_path('/img/group/'. $groupmodel->logo_img));
					//unlink(public_path('/img/group/thumbnail/'. $groupmodel->logo_img));
					/******remove previous storage image**********/

				    $image = $req->file('file_banner');			
					$input['imagename'] = time().'.'.$image->getClientOriginalExtension();
					$destinationPath = public_path('uploads/volunteer_group_banner/');				

					/*********image resize************/
					$destinationPaththumb = public_path('uploads/volunteer_group_banner/thumb');
					$img = Image::make($image->getRealPath());
					$img->save($destinationPath.'/'.$input['imagename']);
					$img->resize(1200, 280, function ($constraint) {
					$constraint->aspectRatio();
					})->save($destinationPaththumb.'/'.$input['imagename']);

					$groupmodel->banner_image = $input['imagename'];
		   		}
		   		//$groupmodel->brif = $req->input('brif');		
			$groupmodel->save();
			$req->session()->flash('success', 'Data successfully Edited');
			return redirect('/admin/group-list');
	    }
	}
	
	public function groupAddVol(Request $req){
		$session=Auth::guard('admin')->user();
		if(count($session)==0){
			return redirect('/admin-login');
		}
		$groupDetails = Group::find($req->id);
		$userlist = User::where('user_role','volunteer')->where('is_deleted',0)->get();
		return view('admin/group_add_vol')->with('list',$userlist)->with('group_id',$req->id)->with('groupDetails',$groupDetails);
	} 
	
	public function groupAddVolPost(Request $req){
		$session=Auth::guard('admin')->user();
		if(count($session)==0){
			return redirect('/admin-login');
		}
		$vol_ids=explode(',',$req->input('vol_ids'));
		$group_id = $req->input('group_id');
		$groupmodel = Group::find($group_id);
		foreach($vol_ids as $vol_id){
			$Group_member = Group_member::where('group_id',$group_id)->where('user_id',$vol_id)->count();
			if($Group_member==0){
				$groupmember = new Group_member;
				$groupmember->group_id = $group_id;	
				$groupmember->user_id = $vol_id;
				$groupmember->role_id = 2;
				$groupmember->status  = 2;
				$groupmember->created_at  = date('Y-m-d H:i:s');
				$groupmember->updated_at  = date('Y-m-d H:i:s');
				$groupmember->is_deleted  = 0;	
				$groupmember->save();
			}			
		}
		$req->session()->flash('success', 'Member successfully inserted into group '.$groupmodel->name);
		return redirect('/admin/group-list');
	}
}
