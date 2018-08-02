<?php

namespace App\Services;

use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Chat;
use App\User;
use App\Group;

class  ChatManager
{

    public function joinUser($user, $myUser)
    {
        $chatService = new ChatService();

        $checkHaveChatUsers = Chat::where('user_id', $user->id)->where('to_user_id', $myUser->id)->first();
        $checkHaveChatMyUsers = Chat::where('user_id', $myUser->id)->where('to_user_id', $user->id)->first();

        if ($checkHaveChatUsers == null and $checkHaveChatMyUsers == null) {
            if($user->user_role === 'organization')
                $logoUser = $myUser->logo_img === null ? asset('img/org/001.png') : asset('uploads/' . $myUser->logo_img);
            else{
                $logoUser = $myUser->logo_img === null ? asset('img/logo/member-default-logo.png') : asset('uploads/' . $myUser->logo_img);
            }

	        if($myUser->user_role === 'organization')
		        $logoMyUser = $user->logo_img === null ? asset('img/org/001.png') : asset('uploads/' . $user->logo_img);
	        else{
		        $logoMyUser = $user->logo_img === null ? asset('img/logo/member-default-logo.png') : asset('uploads/' . $user->logo_img);
	        }

            $chatId = $chatService->createChat($this->getNameUser($user), $logoUser, $logoMyUser, $myUser->user_name);
            $chat = new Chat();
            $chat->chat_id = $chatId;
            $chat->user_id = $user->id;
            $chat->to_user_id = $myUser->id;
            $chat->type = Chat::TYPE_FRIENDS;
            $chat->save();

            $chatService->addUserToChat($myUser, $chatId, $this->getNameUser($user), Chat::TYPE_FRIENDS);
            $chatService->addUserToChat($user, $chatId, $this->getNameUser($myUser), Chat::TYPE_FRIENDS);

        }
        elseif($checkHaveChatUsers != null){
            $chatService->addUserToChat($myUser, $checkHaveChatUsers->chat_id, $this->getNameUser($user), Chat::TYPE_FRIENDS);
            $chatService->addUserToChat($user, $checkHaveChatUsers->chat_id, $this->getNameUser($myUser), Chat::TYPE_FRIENDS);
	        $checkHaveChatUsers->to_user_id = $myUser->id;
	        $checkHaveChatUsers->save();
        }
        elseif($checkHaveChatMyUsers != null){
            $chatService->addUserToChat($myUser, $checkHaveChatMyUsers->chat_id, $this->getNameUser($user), Chat::TYPE_FRIENDS);
            $chatService->addUserToChat($user, $checkHaveChatMyUsers->chat_id, $this->getNameUser($myUser), Chat::TYPE_FRIENDS);
	        $checkHaveChatMyUsers->to_user_id = $user->id;
	        $checkHaveChatMyUsers->save();
        }
    }

    public function createChatUserToUser($user){
//
    }

    public function removeUserFromGroup($id){
        $user = User::find($id);
        $myUser = Auth::user();
        $chatService = new ChatService();

        $checkHaveChatUsers = Chat::where('user_id', $user->id)->where('to_user_id', $myUser->id)->first();
        $checkHaveChatMyUsers = Chat::where('user_id', $myUser->id)->where('to_user_id', $user->id)->first();

        if ($checkHaveChatUsers !== null) {
            $chatService->removeUserFromChat($checkHaveChatUsers->chat_id, $user->user_name, $checkHaveChatUsers->type);
            return $checkHaveChatUsers;
        }
        elseif($checkHaveChatMyUsers !== null) {
            $chatService->removeUserFromChat($checkHaveChatMyUsers->chat_id, $user->user_name, $checkHaveChatMyUsers->type);
	        return $checkHaveChatMyUsers;
        }
    }

	public function deleteChat($chat)
	{
		$chatService = new ChatService();
		$user = User::find($chat->user_id);
		$chatService->removeChat($chat, $user->user_name);
		Chat::where('chat_id', $chat->chat_id)->delete();
	}

    public function joinToGroup($group_id){
        $user = Auth::user();
        $chat = Chat::where('group_id', $group_id)->first();

        if($chat != null){
            $chatService = new ChatService();
            $group = Group::where('id', $group_id)->first();
            $chatService->addUserToChat($user, $chat->chat_id, $group->name,'groups');
        }
    }

    public function join($id)
    {
        $user = User::find($id);
        $myUser = Auth::user();

//        if ($user->user_role == 'volunteer' and $myUser->user_role == 'volunteer') {
            $this->joinUser($user, $myUser);
//        } else {
//            $this->joinOrganization($user, $myUser);
//        }
    }

    public function getNameUser($user)
    {
        $userName = $user->org_name;

        if ($user->user_role === 'volunteer') {
            $userName = $user->getFullNameVolunteer();
        }

        return $userName;
    }

    public function joinOrganization($user, $opportunity)
    {
        $chatService = new ChatService();

        /*if($myUser->user_role === 'organization' and $user->user_role === 'organization'){
            $chat = Chat::where('user_id', $user->id)->whereNull('to_user_id')->first();
            if($chat != null) {
                $chatService->addUserToChat($myUser, $chat->chat_id, $this->getNameUser($user), Chat::TYPE_ORGANIZATIONS);
            }
        }
        elseif($myUser->user_role === 'organization'){
            $chat = Chat::where('user_id', $myUser->id)->whereNull('to_user_id')->first();
            if($chat != null) {
                $chatService->addUserToChat($user, $chat->chat_id, $this->getNameUser($myUser), Chat::TYPE_ORGANIZATIONS);
            }
        }
        else{
            $chat = Chat::where('user_id', $user->id)->whereNull('to_user_id')->first();
            if($chat != null) {
                $chatService->addUserToChat($myUser, $chat->chat_id, $this->getNameUser($user), Chat::TYPE_ORGANIZATIONS);
            }
        }*/
	    $chat = Chat::where('group_id', $opportunity->id)->whereNull('to_user_id')->first();
	    if($chat != null) {
		    $chatService->addUserToChat($user, $chat->chat_id, $opportunity->title, Chat::TYPE_ORGANIZATIONS);
	    }
    }
}