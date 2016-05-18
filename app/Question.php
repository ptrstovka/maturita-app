<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $fillable = ['content', 'answer_id', 'assigned_to', 'subject_id', 'status', 'subcontent'];

	public function subject()
	{
		return $this->hasOne('App\Subject', 'id', 'subject_id');
	}

	public function user()
	{
		return $this->hasOne('App\User', 'id', 'assigned_to');
	}

	public function answer() {
		return $this->hasOne('App\Answer', 'id', 'answer_id');
	}

	public function shortContent()
	{
		return str_limit($this->content, 60);
	}

	public function comments(){
		return $this->hasMany('App\Comment', 'question_id', 'id');
	}

	public function getStatusLabel()
	{
		if ($this->answer_id != 0) {
			return '<span class="label label-success">SPRACOVANÁ</span>';
		}

		if ($this->answer_id == 0 && $this->assigned_to != 0) {
			return '<span class="label label-warning">ČAKÁ</span>';
		}

		return '<span class="label label-danger">NEVYPRACOVANÁ</span>';

	}
	
	public function hasSubcontent(){
		return $this->subcontent != null || $this->subcontent != "";
	}

	public function getStatusAsLabel() {
		switch ($this->status) {
			case 1:
				return '<span class="label label-warning">ČAKÁ</span>';
			case 2:
				return '<span class="label label-success">SPRACOVANÁ</span>';
			case 3:
				return '<span class="label label-info">BULLSHIT</span>';
			case 4:
				return '<span class="label label-warning">PRACUJEM NA TOM</span>';
		}
		return '<span class="label label-danger">NEVYPRACOVANÁ</span>';
	}
	
	public function isSolved() {
		return $this->answer_id != 0;
	}
	
	public function getAssignedToName()
	{

		if ($this->user == null) {
			return 'nepridelená';
		}

		return '<a>' . $this->user->fullName() . '</a>';
		
	}

	public function getUrl() {
		return route('questions.show', $this->id);
	}

	public function getAnswerText() {
		if($this->answer == null) {
			return 'Pre túto otázku nebola zverejnené žiadna odpoveď. Pridaj odpoveď kliknutím <a href="'.  $this->getEditUrl() .'">sem</a>.';
		}

		return $this->answer->content;
	}

	public function getEditUrl() {
		return route('questions.edit', $this->id);
	}

}
