<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity_category extends Model
{
	protected $table = 'opportunity_categories';

	protected $fillable = [
		'name',
		'logo',
	];

	public $timestamps = false;

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'category_id', 'id');
    }
}
