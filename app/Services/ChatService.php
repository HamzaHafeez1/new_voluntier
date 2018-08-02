<?php
/**
 * Created by PhpStorm.
 * User: Trembach.V
 * Date: 07.06.2018
 * Time: 14:24
 */

namespace App\Services;

use Firebase\JWT\JWT;
use Auth;
use Kreait\Firebase\Configuration;
use Kreait\Firebase\Firebase;

class ChatService
{
	private $_firebase;

	function __construct()
	{
		$config = new Configuration();
		$config->setAuthConfigFile( app_path() . config('services.firebase')['config_file'] );
		$this->_firebase = new Firebase('https://' . config('services.firebase')['database_name'] . '.firebaseio.com', $config);
		$this->_firebase->setAuthOverride('myvoluntier-backend-service', []);
	}

	public function createChatUser($username, $displayName, $photo)
	{
		$user = array( 'Id' => $username, 'name' => $displayName, 'photo' => $photo );
		$this->_firebase->set( $user, "users/$username" );
	}

	public function createChat($title, $photo, $photo2 = null, $userId = null)
	{
		$chat = array('name' => $title, 'photo' => $photo, 'Id' => '');
		if(!empty($userId)) $chat[$userId] = $photo2;
		$chatId = $this->_firebase->push($chat, 'chats');
		$chat['Id'] = $chatId;
		$this->_firebase->set($chat, "chats/$chatId");

		return $chat['Id'];
	}

	public function addUserToChat($user, $chatId, $chatName, $type)
	{
	    $userName = $user->user_role === 'organization' ? $user->org_name : $user->getFullNameVolunteer();
		$member = array('name' => $userName, 'chatId' => $chatId, 'unread' => 0);
		$this->_firebase->set( $member, "members/$chatId/$user->user_name");
		$this->_firebase->set( $chatName, "users/$user->user_name/chats/$type/$chatId");
	}

	public function removeUserFromChat($chatId, $userId, $type)
	{
		$this->_firebase->delete("members/$chatId/$userId");
		$this->_firebase->delete("users/$userId/chats/$type/$chatId");
	}

	public function removeChat($chat, $userId)
	{
		$this->_firebase->delete("messages/$chat->chat_id");
		$this->_firebase->delete("chats/$chat->chat_id");
		$this->_firebase->delete("members/$chat->chat_id");
		$this->_firebase->delete("users/$userId/chats/$chat->type/$chat->chat_id");
	}

	public function updateUserInfo($user)
	{
        $userFirstOrOrgName = $user->user_role === 'organization' ? $user->org_name : $user->getFullNameVolunteer();
	    $userName = $user->user_name;
		if($user->user_role === 'organization')
			$logoUser = $user->logo_img === null ? asset('img/org/001.png') : asset('uploads/' . $user->logo_img);
		else{
			$logoUser = $user->logo_img === null ? asset('img/logo/member-default-logo.png') : asset('uploads/' . $user->logo_img);
		}
		$user = array( 'Id' => $userName, 'name' => $userFirstOrOrgName, 'photo' => $logoUser );
		$this->_firebase->update( $user, "users/$userName" );
	}

	public function updateChatInfo($chatId, $name, $photo, $userId = null)
	{
		$chat = array('name' => $name, 'Id' => $chatId);
		if($userId == null)
		{
			$chat['photo'] = $photo;
		}
		else
		{
			$chat[$userId] = $photo;
		}
		$this->_firebase->update($chat, "chats/$chatId");
	}
}