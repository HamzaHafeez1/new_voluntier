<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsfeedModel extends Model
{
	protected $table='news_feeds';

    public function user()
    {
        return $this->belongsTo(User::class, 'who_joined', 'id');
    }
}
