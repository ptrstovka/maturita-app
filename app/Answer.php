<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['content', 'user_id'];
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}
	
}
