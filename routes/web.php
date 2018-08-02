<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function () {
	Route::auth();
	Route::get('/', 'UserCtrl@showLanding')->name('home');
	Route::get('/features', 'UserCtrl@showFeatures')->name('features');
	Route::get('/pricing', 'UserCtrl@showPricing');
	Route::get('/request', 'UserCtrl@showRequest')->name('request');
	Route::get('/login', function (){return redirect()->to('/');});
	Route::get('/terms_conditions', 'UserCtrl@terms_conditions');
	Route::post('api/reg_volunteer', 'UserCtrl@regVolunteer');
	Route::post('api/reg_organization', 'UserCtrl@regOrganization');
	Route::post('api/login_user', 'UserCtrl@login');
	Route::get('/confirm_account/{user_name}/{token}', 'UserCtrl@confirmAccount');
	Route::post('api/forgot_password' ,'UserCtrl@forgotPassword');
	Route::get('/forgot_password/{user_name}/{token}', 'UserCtrl@changeForgotPassword');
	Route::post('api/create_new_password', 'UserCtrl@createNewPassword');
	Route::post('api/forgot_username', 'UserCtrl@forgotUsername');
	/*shared profile*/
	Route::get('profile/{id}', 'SharingCtrl@sharedProfilePage');
	/*send request*/
	Route::post('api/send_request','SharingCtrl@sendRequest');

	Route::post("store",'UserCtrl@updateName');

	Route::post('/status_post', 'UserCtrl@statusPost');
	Route::post('/status_delete', 'UserCtrl@statusDelete');


	//admin
	Route::get('/admin/index', 'Admin\AdminLoginController@index')->name('admin-login');
	Route::post('/admin-login', 'Admin\AdminLoginController@login')->name('admin-login');
	Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function() {

		Route::get('/user-list', 'Admin\Userlist@listing')->name('user-list');
		Route::get('/pending','Admin\Userlist@pending')->name('group-list');

		Route::get('/dashboard', 'Admin\AdminLoginController@dashboard');

		Route::get('/admin-logout', 'Admin\AdminLoginController@logout')->name('admin-logout');
		Route::get('/resetPassword', 'Admin\AdminLoginController@resetPassword')->name('admin-resetPassword');
		Route::post('/forgot', 'Admin\AdminLoginController@forgot')->name('admin-forgot');
		Route::get('/user-delete/{id}', 'Admin\Userlist@deleting')->name('admin-delete');
		Route::get('/user-editing/{id}', 'Admin\Userlist@editing')->name('admin-editing');
		Route::get('/cancel-list','Admin\Userlist@cancelUser');
		Route::post('/editPost','Admin\Userlist@editPost');
		Route::post('/multipleDelete','Admin\Userlist@multipleDelete');
		Route::get('import-export-csv-excel', 'Admin\Userlist@importExportExcelORCSV');
	    Route::post('import-csv-excel', 'Admin\Userlist@importFileIntoDB');
		Route::get('/showusertemdata/{data}','Admin\Userlist@showUserTemData');
		Route::post('/showusertemdatapost','Admin\Userlist@showUserTemDataPost');
		Route::get('/group-list', 'Admin\GroupManageController@listing')->name('group-list');
		Route::get('/group-delete/{id}', 'Admin\GroupManageController@deleting')->name('group-delete');
		Route::get('/group-editing/{id}', 'Admin\GroupManageController@editing')->name('group-editing');
		Route::post('/groupeditPost','Admin\GroupManageController@editPost');
		Route::get('/group_add_vol/{id}','Admin\GroupManageController@groupAddVol');
		Route::post('/group_add_vol_post','Admin\GroupManageController@groupAddVolPost');
		Route::post('/approve','Admin\Userlist@approve');
		Route::post('/reject','Admin\Userlist@reject');
	});
});

Route::group(['middleware' => 'org'], function(){
	/*homepage*/
	Route::get('/organization/','Organization\HomeCtrl@viewHome')->name('home-organization');
	Route::post('api/organization/profile/upload_logo','Organization\HomeCtrl@upload_logo');
	Route::get('/organization/search','Organization\HomeCtrl@Search')->name('organization-search');
	Route::post('api/organization/joinGroup','Organization\HomeCtrl@joinGroup');
	/*account page*/
	Route::get('/organization/accountSetting','Organization\HomeCtrl@viewEditAccount')->name('organization-account-setting');
	Route::post('api/organization/update_account','UserCtrl@update_account');
	/*profile page*/
	Route::get('/organization/profile/{id?}','Organization\HomeCtrl@viewProfile')->name('view-organization-profile');
	Route::post('api/organization/profile/upload_back_img','Organization\HomeCtrl@upload_back_img');
	/*opportunity*/
	Route::get('/organization/opportunity/{id?}','Organization\OpportunityCtrl@viewManageOpportunity')->name('organization-opportunity');
	Route::get('/organization/post_opportunity','Organization\OpportunityCtrl@viewPostingPage')->name('organization-opportunity-post');
	Route::post('api/organization/post_opportunity','Organization\OpportunityCtrl@postOpportunity');
	Route::get('/organization/edit_opportunity/{id?}','Organization\OpportunityCtrl@viewUpdatingPage');
	Route::post('api/organization/edit_opportunity/{id}','Organization\OpportunityCtrl@updateOpportunity');
	Route::get('/organization/view_opportunity/{id?}','Organization\OpportunityCtrl@viewOpportunity')->name('view-opportunity-profile');
	Route::post('api/organization/delete_opportunity','Organization\OpportunityCtrl@deleteOpportunity')->name('api-organization-delete_opportunity');
	/*track*/
	Route::get('/organization/track','Organization\TrackingCtrl@viewTrackingPage')->name('organization-track');
	Route::post('api/organization/track/approve','Organization\TrackingCtrl@approveTrack');
	Route::post('api/organization/track/decline','Organization\TrackingCtrl@declineTrack');
	Route::get('/organization/track/customConfirm/{track_id}/{confirm_code}','Organization\TrackingCtrl@confirmCustomTrack');
	Route::get('/organization/approve/{id?}/{status?}','Organization\TrackingCtrl@approveGroupRequest');
	/*Group*/
	Route::get('/organization/group','Organization\GroupCtrl@viewGroupPage')->name('organization-group');
	Route::get('/organization/group/group_add/{id?}','Organization\GroupCtrl@viewGroupAddPage')->name('organization-group-group_add');
	Route::post('api/organization/group/create_org_group','Organization\GroupCtrl@createGroup');
	Route::post('api/organization/group/change_org_group','Organization\GroupCtrl@changeGroup');
	Route::get('/organization/group/view_group_detail/{group_id}','Organization\GroupCtrl@viewGroupDetail');
	Route::get('/organization/group/group_search','Organization\GroupCtrl@searchGroup');
	Route::post('api/organization/group/get_user','Organization\GroupCtrl@getUserList')->name('api-organization-group-get-user');
	Route::post('api/organization/group/add_user_invitation','Organization\GroupCtrl@addUserInvitation');
	Route::post('api/organization/group/get_members_groups_by_name', 'Organization\GroupCtrl@getUserByGroup')->name('get_user_by_group');
	/*Follow*/
	Route::post('api/organization/followOrganization','Organization\HomeCtrl@followOrganization');
	Route::post('api/organization/unfollowOrganization','Organization\HomeCtrl@unfollowOrganization');
	Route::post('api/organization/followGroup','Organization\GroupCtrl@followGroup');
	Route::post('api/organization/unfollowGroup','Organization\GroupCtrl@unfollowGroup');
	/*Join to Group*/
	Route::post('api/organization/jointoGroup','Organization\GroupCtrl@jointoGroup');
	Route::get('/organization/leave_group/{id?}','Organization\GroupCtrl@leaveGroup');
	/*Friend*/
	Route::get('/organization/friend','Organization\FriendCtrl@viewFriendPage')->name('organization-friend');
	Route::post('/organization/friend_accept_reject','Volunteer\FriendCtrl@accept_reject')->name('organization-friend-accept-reject');
    Route::post('api/organization/group/get_friend','Organization\FriendCtrl@getFriend')->name('organization-get-friend');
	/*connect Friend*/
	Route::post('api/organization/connectOrganization','Organization\HomeCtrl@connectOrganization');
	Route::post('api/organization/acceptFriend','Organization\HomeCtrl@acceptFriend')->name('organization-accept-friend');
	/*Organization Impact*/
	Route::get('/organization/impact','Organization\OpportunityCtrl@impactPage')->name('organization-impact');
	/* send message */
	Route::post('api/organization/sendmessage','Organization\HomeCtrl@sendMessage');
    /* send message */
    Route::get('/organization/chat','ChatController@index')->name('organization-chat');
});

Route::group(['middleware' => 'vol'], function(){
	/*homepage*/
	Route::get('/volunteer/','Volunteer\HomeCtrl@viewHome')->name('home-volunteer');
	Route::post('api/volunteere/upload_logo','Volunteer\HomeCtrl@upload_logo');
	Route::get('/volunteer/search','Volunteer\HomeCtrl@Search')->name('volunteer-search');
	Route::post('api/volunteer/joinGroup','Volunteer\HomeCtrl@joinGroup');
	/*account page*/
	Route::get('/volunteer/accountSetting','Volunteer\HomeCtrl@viewEditAccount')->name('volunteer-account-setting');;
	Route::post('api/volunteer/update_account','UserCtrl@update_volunteer_account');
	/*profile page*/
	Route::get('/volunteer/profile/{id?}','Volunteer\HomeCtrl@viewProfile')->name('view-voluntier-profile');
	Route::post('api/volunteer/profile/upload_back_img','Volunteer\HomeCtrl@upload_back_img');
	/*impact*/
	Route::get('/volunteer/impact','Volunteer\HomeCtrl@viewImpact')->name('volunteer-impact');
	Route::post('api/volunteer/impact/getFriendInfo','Volunteer\HomeCtrl@getFriendInfo')->name('volunteer-get-friend-info');
	Route::get('volunteer/impact/getFriendInfo','Volunteer\HomeCtrl@viewImpact');
	/*opportunities*/
	Route::get('/volunteer/opportunity','Volunteer\OpportunityCtrl@viewOpportunity')->name('volunteer-opportunity');
	Route::get('/volunteer/opportunity/search','Volunteer\OpportunityCtrl@viewLocationOpportunity')->name('volunteer-opportunity-search');
	Route::get('/volunteer/view_opportunity/{id?}','Volunteer\OpportunityCtrl@viewOpportunityPage')->name('volunteer-view-opportunity-profile');
	Route::post('api/volunteer/opportunity/join','Volunteer\OpportunityCtrl@joinOpportunity');
	Route::post('api/volunteer/find_opportunity_on_map','Volunteer\OpportunityCtrl@findOnMap');
	Route::get('api/volunteer/opportunity/getSearchResult','Volunteer\OpportunityCtrl@getSearchResult');
	/*track*/
	Route::get('/volunteer/track','Volunteer\TrackingCtrl@viewTrackingPage')->name('volunteer-track');
	Route::get('/volunteer/single_track','Volunteer\TrackingCtrl@viewSingleTrackingPage')->name('volunteer-single_track');
	Route::get('/volunteer/approve/{id?}/{status?}','Volunteer\TrackingCtrl@approveGroupRequest');
	Route::post('api/volunteer/track/getOpportunities','Volunteer\TrackingCtrl@getOpportunityNames');
	Route::post('api/volunteer/track/joinToOpportunity','Volunteer\TrackingCtrl@joinToOpportunity');
	Route::post('api/volunteer/track/addHours','Volunteer\TrackingCtrl@addHours')->name('volunteer-track-addHours');
	Route::post('api/volunteer/track/removeHours','Volunteer\TrackingCtrl@removeHours');
	Route::get('api/volunteer/track/viewTracks','Volunteer\TrackingCtrl@viewTracks')->name('volunteer-track-view-tracks');
	Route::get('api/volunteer/track/activityView','Volunteer\TrackingCtrl@activityView');
	/*Group*/
    Route::post('api/volunteer/group/get_members_groups_by_name', 'Volunteer\GroupCtrl@getUserByGroup')->name('volunteer-get-user-by-group');

	Route::get('/volunteer/group','Volunteer\GroupCtrl@viewGroupPage')->name('volunteer-group');
	Route::get('/volunteer/group/group_add/{id?}','Volunteer\GroupCtrl@viewGroupAddPage')->name('volunteer-group-group_add');
	Route::post('api/volunteer/group/create_vol_group','Volunteer\GroupCtrl@createGroup');
	Route::post('api/volunteer/group/change_org_group','Volunteer\GroupCtrl@changeGroup');
	Route::post('api/volunteer/group/get_user','Volunteer\GroupCtrl@getUserList')->name('api-volunteer-group-get-user');
	Route::post('api/volunteer/group/add_user_invitation','Volunteer\GroupCtrl@addUserInvitation');
	/*Follow*/
	Route::post('api/volunteer/followOrganization','Volunteer\HomeCtrl@followOrganization');
	Route::post('api/volunteer/unfollowOrganization','Volunteer\HomeCtrl@unfollowOrganization');
	Route::post('api/volunteer/followGroup','Volunteer\GroupCtrl@followGroup');
	Route::post('api/volunteer/unfollowGroup','Volunteer\GroupCtrl@unfollowGroup');
	/*Join to Group*/
	Route::post('api/volunteer/jointoGroup','Volunteer\GroupCtrl@jointoGroup');
	Route::get('/volunteer/leave_group/{id?}','Volunteer\GroupCtrl@leaveGroup');
	/*Friend*/
	Route::get('/volunteer/friend','Volunteer\FriendCtrl@viewFriendPage')->name('volunteer-friend');
	Route::post('/volunteer/friend_accept_reject','Volunteer\FriendCtrl@accept_reject')->name('volunteer-friend-accept-reject');
    Route::post('api/volunteer/group/get_friend','Volunteer\FriendCtrl@getFriend')->name('volunteer-get-friend');
	/*connect Friend*/
	Route::post('api/volunteer/connectOrganization','Volunteer\HomeCtrl@connectOrganization');
	Route::post('api/volunteer/acceptFriend','Volunteer\HomeCtrl@acceptFriend')->name('volunteer-accept-friend');;
		/* send message */
	Route::post('api/volunteer/sendmessage','Volunteer\HomeCtrl@sendMessage');
    /* send message */
	Route::get('/volunteer/chat','ChatController@index')->name('volunteer-chat');
	
	Route::post('/volunteer/commentStatus/{id?}', 'Volunteer\HomeCtrl@statusComment');

});

Route::group(['middleware' => 'auth'], function(){
	Route::get('/signout_user', 'UserCtrl@signout')->name('signout_user');
	/*share_profile*/
	Route::post('api/share_profile','SharingCtrl@shareProfile');
	/*get Message*/
	Route::post('api/getMessages','SharingCtrl@getMessage');

	/*Alert*/
	Route::get('viewAlert','SharingCtrl@viewAlertPage')->name('view-alert');
	Route::post('api/getAlert','SharingCtrl@getAlert');
	Route::get('/chat/token/{uid}','ChatController@create_custom_token')->name('chat-token');

	Route::post('api/deleteChat/{id}', 'ChatController@deleteChat');
});

Route::get('/sharegroup/{id}', 'SharingCtrl@shareGroup');
