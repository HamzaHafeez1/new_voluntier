<?php

namespace App\Http\Controllers\Organization;

use App\Services\ChatManager;
use App\Opportunity;
use App\Review;
use App\Chat;
use App\Services\ChatService;
use App\Tracking;
use App\User;
use App\NewsfeedModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class TrackingCtrl extends Controller
{
	public function viewTrackingPage(Request $request){
		$org_id = Auth::user()->id;
		$tracks = Tracking::where('org_id',$org_id)->where('approv_status',0)->where('is_deleted','<>',1)->orderBy('updated_at','desc')->get();
		$confirm_tracks = array();
		foreach ($tracks as $t){
			$volunteer = User::find($t->volunteer_id);
			$opportunity = Opportunity::find($t->oppor_id);
			$confirm_tracks[$t->id]['track_id'] = $t->id;
			$confirm_tracks[$t->id]['volunteer_id'] = $t->volunteer_id;
			$confirm_tracks[$t->id]['volunteer_name'] = $volunteer->first_name.' '.$volunteer->last_name;
			$confirm_tracks[$t->id]['volunteer_logo'] = $volunteer->logo_img;
			$confirm_tracks[$t->id]['opportunity_id'] = $t->oppor_id;
			$confirm_tracks[$t->id]['opportunity_name'] = $t->oppor_name;
			$confirm_tracks[$t->id]['opportunity_status'] = $opportunity->category_id;
			$confirm_tracks[$t->id]['opportunity_logo'] = $opportunity->logo_img;
			$confirm_tracks[$t->id]['logged_date'] = $t->logged_date;
			$confirm_tracks[$t->id]['started_time'] = $t->started_time;
			$confirm_tracks[$t->id]['ended_time'] = $t->ended_time;
			$confirm_tracks[$t->id]['logged_mins'] = $t->logged_mins;
			$confirm_tracks[$t->id]['updated_at'] = $t->updated_at;
			$confirm_tracks[$t->id]['comment'] = $t->description;
		}
//		dd($confirm_tracks);

		return view('organization.track',['tracks'=>$confirm_tracks,'page_name'=>'org_track']);
	}

	public function approveTrack(Request $request){
		$org_id = Auth::user()->id;
		$track_id = $request->input('track_id');
		$track = Tracking::find($track_id);
		$track->approv_status = Tracking::STATUS_APPROVE;
		$track->confirm_code = null;
		$update = $track->save();
		$vol = User::find($track->volunteer_id);
		$opportunity = Opportunity::find($track->oppor_id);
		$opp_chat = Chat::where('group_id', $track->oppor_id)->first();
		$manager      = new ChatManager();
		if($opp_chat == null)
		{
			$chat_service = new ChatService();
			$photo        = $opportunity->logo_img === null ? asset('img/org/001.png') : asset( 'uploads/' . $opportunity->logo_img );
			$chatId       = $chat_service->createChat( $opportunity->title, $photo );
			$chat_service->addUserToChat( Auth::user(), $chatId, $opportunity->title, 'organizations' );
			$chat           = new Chat();
			$chat->chat_id  = $chatId;
			$chat->user_id  = Auth::user()->id;
			$chat->group_id = $opportunity->id;
			$chat->type     = 'organizations';
			$chat->save();
		}
		$manager->joinOrganization( $vol, $opportunity );
		if($update){
			$newsfeed  = new NewsfeedModel;
                $newsfeed->who_joined  = $org_id;
                $newsfeed->related_id   = $track->volunteer_id;
                $newsfeed->table_name  = 'tracked_hours';
                $newsfeed->table_id   = $track_id;
                $newsfeed->reason   = 'opportunity approved';
                $newsfeed->created_at    = date('Y-m-d H:i:s');
                $newsfeed->updated_at    = date('Y-m-d H:i:s');
                $newsfeed->save(); 
		}

		if($request->input('is_review') == 1){
			$review = Review::where('review_from',$org_id)->where('review_to',$track->volunteer_id)->where('is_deleted','<>',1)->get()->first();
			if($review == null){
				$review = new Review;
				$review->review_from = $org_id;
				$review->review_to = $track->volunteer_id;
				$review->mark = $request->input('review_score');
				$review->comment = $request->input('review_comment');
				$review->save();
			}else{
				$review->review_from = $org_id;
				$review->review_to = $track->volunteer_id;
				$review->mark = $request->input('review_score');
				$review->comment = $request->input('review_comment');
				$review->save();
			}
		}

		Return Response::json(['result'=>'success']);
	}

	public function declineTrack(Request $request){
		$track_id = $request->input('track_id');
		$track = Tracking::find($track_id);
		$track->approv_status = Tracking::STATUS_DECLINE;
		$track->confirm_code = null;
		$track->save();

		Return Response::json(['result'=>'success']);
	}

	public function confirmCustomTrack($track_id,$confirm_code){
		$org_id = Auth::user()->id;
		$track = Tracking::find($track_id);

		if($track->confirm_code == $confirm_code){
			$new_opp = new Opportunity;
			$new_opp->org_id = $org_id;
			$new_opp->org_type = User::find($org_id)->org_type;
			$new_opp->title = $track->oppor_name;
			$new_opp->type = 2;
			$new_opp->save();

			$track->org_id = $org_id;
			$track->oppor_id = $new_opp->id;
			$track->save();

			$confirm_tracks = array();
			$volunteer = User::find($track->volunteer_id);
			$opportunity = Opportunity::find($track->oppor_id);
			$confirm_tracks['track_id'] = $track->id;
			$confirm_tracks['volunteer_id'] = $track->volunteer_id;
			$confirm_tracks['volunteer_name'] = $volunteer->first_name.' '.$volunteer->last_name;
			$confirm_tracks['volunteer_logo'] = $volunteer->logo_img;
			$confirm_tracks['opportunity_id'] = $track->oppor_id;
			$confirm_tracks['opportunity_name'] = $track->oppor_name;
			$confirm_tracks['opportunity_status'] = $opportunity->category_id;
			$confirm_tracks['opportunity_logo'] = $opportunity->logo_img;
			$confirm_tracks['logged_date'] = $track->logged_date;
			$confirm_tracks['started_time'] = $track->started_time;
			$confirm_tracks['ended_time'] = $track->ended_time;
			$confirm_tracks['logged_mins'] = $track->logged_mins;
			$confirm_tracks['updated_at'] = $track->updated_at;
			$confirm_tracks['comment'] = $track->description;
			return view('organization.confirmCustomTrack',['track'=>$confirm_tracks,'page_name'=>'']);
		}else{
			return redirect()->to('/');
		}
	}
	public function approveGroupRequest($group_id = '',$status = ''){
		$Group_member = Group_member::where('id',$group_id)->get();
		if(count($Group_member)>0)
		{
			Group_member::where('id',$group_id)->update(['status'=>$status]);
			$is_approved = 2;
			if($status==2)
			{
                $chatManager = new ChatManager();
                $chatManager->joinToGroup($Group_member[0]->group_id);

				$is_approved = 1;
			}
			Alert::where('related_id',$group_id)->update(['related_id'=>0,'is_apporved'=>$is_approved]);
		}

		return redirect()->to('/viewAlert');
	}
}
