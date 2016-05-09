<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['user_id', 'question_id', 'content'];
	
	public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');
	}
	
}
