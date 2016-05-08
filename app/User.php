<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'token'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'is_activated' => 'boolean'
	];
	
	protected $appends = ['questions'];

	/**
	 * Send activation mail to user.
	 */
	public function sendActivationEmail()
	{
		$mailData = [
			'to'       => $this->email,
			'from'     => 'noreply@jasompeter.com',
			'nameFrom' => 'Peter Štovka'
		];


		Mail::send('email.activation', ['token' => $this->token], function ($message) use ($mailData) {
			$message->to($mailData['to'], 'Aktivačný email')
				->subject('Aktivácia účtu')
				->from($mailData['from'], $mailData['nameFrom']);
		});
	}

	public function fullName() {
		return $this->first_name . ' ' . $this->last_name;
	}
	
	public function activate() {
		$this->is_activated = true;
		$this->save();
	}

	public function isVerified() {
		return $this->solved_questions >= 8;
	}
	
	public function isAdmin() {
		return $this->role == 10;
	}

	public function getQuestionsAttribute() {
		return Question::where('assigned_to', $this->id)->get();
	}

	public function categories() {
		return $this->belongsToMany('App\Category');
	}
	
	public function hasCategory($category) {
		
		foreach ($this->categories as $cat) {
			if($cat->id == $category) {
				return true;
			}
		}
		
		return false;
	}
	
}
