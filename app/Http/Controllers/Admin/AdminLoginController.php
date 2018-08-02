<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Session;
//Using Request for admin form validation
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\ForgotRequest;
use App\Models\Admin;
use App\CommonModel;

class AdminLoginController extends Controller
{
    public function index()
	{ //die('hiii');
		$session=Auth::guard('web')->user();
		//echo Hash::make(123456); die;
		return view('admin/index');
	}
	
	public function login(AdminLoginRequest $req)
	{ 
		if(!empty($req->input())) {
			$userData = Admin::where('username', $req->input('email'));
			if($userData->count() > 0) {
				$details = $userData->first();
				if(Hash::check($req->input('password'), $details->password)) {
					$mapData = ['username' => $req->input('email'), 'password' => $req->input('password')];
					if (Auth::guard('admin')->attempt($mapData)) {
						Auth::guard('admin')->login($details);
					}
					$data = Auth::guard('admin')->user();
					//Auth::logout();
					$req->session()->flash('success', 'Login Sucessful');
					return redirect('/admin/dashboard');
				}else{
					
					$req->session()->flash('warning', 'incorrect password');
					return redirect('/admin/index');
				}
			}else{
				$req->session()->flash('warning', 'Not found');
					return redirect('/admin/index');
			}
		}
	}
	
	public function logout(Request $req)
	{
		Auth::logout();
        $req->session()->flush();
        return redirect('/admin/index');
	}
	
	public function resetPassword()
	{		
        return view('admin/reset');
	}
	
	public function forgot(ForgotRequest $req)
	{  
		if(!empty($req->input())) {
			$userData = Admin::where('username', $req->input('email'))->first();
			
			if(count($userData) > 0) {
				$adminModel = Admin::find($userData->id);
				$password=Hash::make($req->input('password'));
				$adminModel->password = $password;
				$adminModel->save();
				$req->session()->flash('success', 'password changed');
				return redirect('/admin/index');
			}else{
				$req->session()->flash('warning', 'denied');
					return redirect('/admin/resetPassword');
			}
		}
	}

	public function dashboard()
	{	
        $userLists = CommonModel::getAll('users');
        $groupLists = CommonModel::getAll('group_members');
        return view('admin/dashboard',compact('userLists','groupLists'));
	}
}
