<?php

namespace App\Http\Controllers\Volunteer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alert;
use App\Friend;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\Paginator;
use App\Services\ChatManager;
use App\Services\ChatService;

class FriendCtrl extends Controller
{
    public function viewFriendPage()
    {
        $user_id = Auth::user()->id;

        $new_request = DB::table('users')
            ->join('friends', 'users.id', '=', 'friends.user_id')
            ->where('friends.friend_id', $user_id)
            ->where('friends.is_deleted', '<>', 1)
            ->where('friends.status', 1)
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', 1)
            ->select('users.*', 'friends.*')
            ->get();

        $friends = DB::table('users')
            ->join('friends', 'users.id', '=', 'friends.friend_id')
            ->where('friends.user_id', $user_id)
            ->where('friends.is_deleted', '<>', 1)
            ->where('friends.status', 2)
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', 1)
            ->select('users.*', 'friends.*')
            ->paginate(12);

        return view('organization.friend',
            ['page_name' => 'vol_friend',
            'nameClassUl' => 'friends-list-main',
            'friend_requests' => $new_request,
            'friends' => $friends,
            'user_id' => $user_id]);
    }

    public function getFriend(Request $request)
    {
        $keyword = $request->get('keyword');

        $friends = DB::table('users')
            ->join('friends', 'users.id', '=', 'friends.friend_id')
            ->where('friends.user_id', Auth::user()->id)
            ->where('friends.is_deleted', '<>', 1)
            ->where('friends.status', 2)
            ->where('users.is_deleted', '<>', 1)
            ->where('users.confirm_code', 1)
            ->where(function ($query) use ($keyword) {
                $query->where("users.first_name", "LIKE", "%$keyword%")
                    ->orWhere("users.last_name", "LIKE", "%$keyword%")
                    ->orWhere("users.org_name", "LIKE", "%$keyword%");
            })
            ->select('users.*', 'friends.*')
            ->get();

        return view('organization.friendsUserList', ['friends' => $friends, 'nameClassUl' => 'friends-list-search']);
    }

    public function accept_reject(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->sender;

        $friend = Friend::find($request->id);
        $post_user_id   = $request->user_id;
        $post_friend_id = $request->sender;
        $type           = $request->type;
        $status         = $request->status;
        
        if ($user_id != $post_user_id) {
            return Response::json(['error' => 'Something error occured. Try agatn later.',
                    'success' => '0']);
        }

        if ($status == 2) {
            $friend->status = $request->status;
            $friend->save();
            $update         = Friend::where('friend_id', '=', $post_friend_id)
                ->where('user_id', '=', $user_id)
                ->where('status', '=', 3);
            $update->update(['status' => '2']);

            $chatManager = new ChatManager();
            $chatManager->join($id);

            return Response::json(['error' => '', 'success' => '1']);
        }
        if ($status == 0) {
            $friend->is_deleted = 1;
            $friend->save();
            /*  also delete record from alert table */
            Alert::where('receiver_id',$user_id)->where('sender_id',$post_friend_id)->delete();
            Alert::where('receiver_id',$post_friend_id)->where('sender_id',$user_id)->delete();

            if($type == 1){
                $update     = Friend::where('user_id', '=', $user_id)
                            ->where('friend_id', '=', $post_friend_id)
                            ->update(['is_deleted' => 1]);
            }else{
                $update     = Friend::where('user_id', '=', $post_friend_id)
                            ->where('friend_id', '=', $user_id)
                            ->update(['is_deleted' => 1]);

                /*$chatManager = new ChatManager();
                $removed = $chatManager->removeUserFromGroup($id);
                $chatManager->deleteChat($removed);*/
            }

            return Response::json(['error' => '', 'success' => '1']);
        }
        return Response::json(['error' => 'Something error occured. Try agatn later.',
                'success' => '0']);
    }
}
