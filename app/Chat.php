<?php
/**
 * Created by PhpStorm.
 * User: Trembach.V
 * Date: 07.06.2018
 * Time: 18:16
 */

namespace App;
use Illuminate\Database\Eloquent\Model;


class Chat extends Model
{
    const TYPE_GROUPS = 'groups';
    const TYPE_ORGANIZATIONS = 'organizations';
    const TYPE_FRIENDS = 'friends';

	protected $table='user_chat';
}