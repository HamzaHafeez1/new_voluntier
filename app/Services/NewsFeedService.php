<?php

namespace App\Services;

use App\Opportunity_member;
use App\Group_member;
use App\Opportunity;
use App\Tracking;
use App\Group;


class NewsFeedService
{
    public function transformNewsFeedToArrayInfo($newsFeeds, $typeUser)
    {
        $fieldFeedNewsArr = $typeUser === 'organization' ? 'created_at' : 'who_joined_imag';
        $users = [];

        foreach ($newsFeeds as $key => $value) {
            if (array_key_exists($value->who_joined, $users)) {
                $userWhoJoined = $users[$value->who_joined];
            } else {
                $userWhoJoined = $value->user;
                $users[$value->who_joined] = $userWhoJoined;
            }

            $first_name = $userWhoJoined->first_name ? $userWhoJoined->first_name : '';
            $last_name = $userWhoJoined->last_name ? $userWhoJoined->last_name : '';
            $user_role = $userWhoJoined->user_role;

            if ($user_role == 'organization') {
                $uname = $userWhoJoined->org_name;
                $logoDef = 'front-end/img/org/001.png';
                $userurl = 'organization/profile/' . $value->who_joined;
            } elseif ($user_role == 'volunteer') {
                $uname = $first_name . ' ' . $last_name;
                $logoDef = 'img/noprofilepic.png';
                $userurl = 'volunteer/profile/' . $value->who_joined;
            }

            if ($typeUser === 'organization') {
                $created_at = $value->created_at ? $value->created_at : '';
            } else {
                $logo_img = $userWhoJoined->logo_img ? '/uploads/' . $userWhoJoined->logo_img : $logoDef;
            }

            $name = '';
            $utl = 'javascript:void(0)';

            if ($value['table_name'] == 'group_members') {
                $group_id = Group_member::find($value['table_id'])->group_id;
                $name = Group::find($group_id)->name;
                $utl = 'sharegroup/' . base64_encode($group_id);
            } else if ($value['table_name'] == 'opportunity_members') {
                $oppor_id = Opportunity_member::find($value['table_id'])->oppor_id;
                $name = Opportunity::find($oppor_id)->title;
                $utl = 'organization/view_opportunity/' . $oppor_id;

            } else if ($value['table_name'] == 'opportunities') {
                $name = Opportunity::find($value['table_id'])->title;
                $utl = 'organization/view_opportunity/' . $value['table_id'];

            } else if ($value['table_name'] == 'tracked_hours') {
                $name = Tracking::find($value['table_id'])->oppor_name;
                $utl = 'organization/view_opportunity/' . $value['table_id'];
            }

            $feedNewsArr[] = [
                'who_joined' => $uname,
                'reason' => $value['reason'],
                'name' => $name,
                'utl' => $utl,
                'userurl' => $userurl,
                $fieldFeedNewsArr => $typeUser === 'organization' ? $created_at : $logo_img
            ];

        }

        return $feedNewsArr;
    }

}
