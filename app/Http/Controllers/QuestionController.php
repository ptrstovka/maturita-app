<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class QuestionController extends Controller
{
    public function indexAll($category) {
	    
	    $user = Auth::user();

	    if(!$user->hasCategory($category)) {
		    return abort(404);
	    }

	    if(!$user->isVerified() && !$user->isAdmin()) {
		    Session::flash('warning', 'Nemáš prístup ku všetkým otázkam lebo si nevypracoval dostatočný počet otázok. 
		    Potrebuješ vypracovať aspoň 8 otázok. Ty si vypracoval ' . $user->solved_questions . '.');
		    return Redirect::to('home');
	    }

	    $questions = Question::where('category_id', $category)->get();

	    return view('questions.index')
		    ->withQuestions($questions);
    }
	
	public function userQuestions($category) {

		if(!Auth::user()->hasCategory($category)) {
			return abort(404);
		}
		
		$questions = Question::where('category_id', $category)->where('assigned_to', Auth::user()->id)->get();

		return view('questions.user')
			->withQuestions($questions);
	}
	
	public function showQuestion($id) {

		$question = Question::findOrFail($id);

		if(!Auth::user()->hasCategory($question->category_id)) {
			return abort(404);
		}

		if(!Auth::user()->isVerified() && $question->assigned_to != Auth::user()->id && !Auth::user()->isAdmin()) {
			return abort(404);
		}
		
		return view('questions.show')
			->withQuestion($question);
	}
	
	public function editQuestion($id) {

		$question = Question::findOrFail($id);

		if(!Auth::user()->hasCategory($question->category_id)) {
			return abort(404);
		}

		if(!Auth::user()->isVerified() && $question->assigned_to != Auth::user()->id && !Auth::user()->isAdmin()) {
			return abort(404);
		}

		return view('questions.edit')
			->withQuestion($question);
	}
	
	public function updateQuestion(Request $request, $id) {

		$question = Question::findOrFail($id);

		$answer_content = $request->get('answer');

		try {

		$dom = new DomDocument();
		$dom->loadHtml(mb_convert_encoding($answer_content, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

		$images = $dom->getElementsByTagName('img');

		// foreach <img> in the submited message
		foreach($images as $img){
			$src = $img->getAttribute('src');

			// if the img source is 'data-url'
			if(preg_match('/data:image/', $src)){

				// get the mimetype
				preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
				$mimetype = $groups['mime'];

				// Generating a random filename
				$filename = uniqid();
				$filepath = "images/$filename.$mimetype";

				// @see http://image.intervention.io/api/
				$image = Image::make($src)
					// resize if required
					/* ->resize(300, 200) */
					->encode($mimetype, 100) 	// encode file to the specified mimetype
					->save(public_path($filepath));

				$new_src = asset($filepath);
				$img->removeAttribute('src');
				$img->setAttribute('src', $new_src);
			} // <!--endif
		} // <!--endforeach

		$final_content = $dom->saveHTML();

		} catch (Exception $e) {
			Session::flash('warning', 'Skús nekopírovať a otázku vypracovať sám.');
			return back()->withInput();
		}

		if($question->answer == null) {
			// create new answer
			$answer = Answer::create([
				'content' => $final_content,
				'user_id' => Auth::user()->id
			]);

			$question->answer_id = $answer->id;

			if($question->user == null) {
				$question->assigned_to = Auth::user()->id;
			}

			$question->save();

			Auth::user()->solved_questions++;
			Auth::user()->save();

		} else {
			// update existing answer
			$question->answer->content = $final_content;
			$question->answer->save();

			if($question->user == null) {
				$question->assigned_to = Auth::user()->id;
				$question->save();
			}

		}

		Session::flash('message', 'Vďaka <i class="fa fa-heart"></i> Tvoja odpoveď k otázke bola zaznamenaná.');
		return Redirect::route('questions.show', $id);
	}
	
}
