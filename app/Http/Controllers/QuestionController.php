<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Comment;
use App\Question;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

/**
 * TODO: Yep, this class has boilerplate code but I don't have time because I must learn for graduation.
 * TODO: If someone can't look at this code, make pull request :P
 * Also.. this app should help me with graduation :)
 */
class QuestionController extends Controller
{
	public function indexAll($category)
	{

		$user = Auth::user();

		if (!$user->hasCategory($category)) {
			return abort(404);
		}

		if (!$user->isVerified() && !$user->isAdmin()) {
			Session::flash('warning', 'Nemáš prístup ku všetkým otázkam lebo si nevypracoval dostatočný počet otázok. 
		    Potrebuješ vypracovať aspoň 8 otázok. Ty si vypracoval ' . $user->solved_questions . '.');

			return Redirect::to('home');
		}

		$questions = Question::where('category_id', $category)->get();

		return view('questions.index')
			->withQuestions($questions);
	}

	public function userQuestions($category)
	{

		if (!Auth::user()->hasCategory($category)) {
			return abort(404);
		}

		$questions = Question::where('category_id', $category)->where('assigned_to', Auth::user()->id)->get();

		return view('questions.user')
			->withQuestions($questions);
	}

	public function showQuestion($id)
	{

		$question = Question::findOrFail($id);

		if (!Auth::user()->hasCategory($question->category_id)) {
			return abort(404);
		}

		if (!Auth::user()->isVerified() && $question->assigned_to != Auth::user()->id && !Auth::user()->isAdmin()) {
			return abort(404);
		}

		$questions = Question::all();
		$next      = 0;
		$prev      = 0;

		// first ID will be passed if questions array is not empty
		if (count($questions) > 0) {
			$next = $questions[0]->id;
		}

		// last ID will be passed
		for ($l = count($questions) - 1; $l > 0; $l--) {
			if (Auth::user()->hasCategory($questions[$l]->category_id)) {
				$prev = $questions[$l]->id;
				break;
			}
		}

		for ($i = 0; $i < count($questions); $i++) {

			$q = $questions[$i];
			if ($q->id == $question->id) {
				if (($i + 1) < count($questions)) {
					if (Auth::user()->hasCategory($questions[$i + 1]->category_id)) {
						$next = $questions[$i + 1]->id;
					}
				}

				if (($i - 1) > -1) {
					if (Auth::user()->hasCategory($questions[$i - 1]->category_id)) {
						$prev = $questions[$i - 1]->id;
					}
				}
			}
		}

		return view('questions.show')
			->withQuestion($question)
			->withNext($next)
			->withPrev($prev);
	}

	public function editQuestion($id)
	{

		$question = Question::findOrFail($id);

		if(env('DISABLE_EDIT', true) && !Auth::user()->isAdmin()) {
			return abort(404);
		}

		if (!Auth::user()->hasCategory($question->category_id)) {
			return abort(404);
		}

		if (!Auth::user()->isVerified() && $question->assigned_to != Auth::user()->id && !Auth::user()->isAdmin()) {
			return abort(404);
		}

		return view('questions.edit')
			->withQuestion($question);
	}

	public function updateQuestion(Request $request, $id)
	{
		if(env('DISABLE_EDIT', true) && !Auth::user()->isAdmin()) {
			return abort(404);
		}

		$question = Question::findOrFail($id);

		if (Auth::user()->isAdmin()) {
			// TODO: make validation
			// but admin should have brain...
			$question->content = $request->get('content');
			$question->save();
		}

		$answer_content = $request->get('answer');

		$final_content = $answer_content;

		if (env('ENABLE_IMAGE_UPLOADS', false)) {
			try {
				$dom = new DomDocument();
				$dom->loadHtml(mb_convert_encoding($answer_content, 'HTML-ENTITIES', "UTF-8"),
					LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

				$images = $dom->getElementsByTagName('img');

				// foreach <img> in the submited message
				foreach ($images as $img) {
					$src = $img->getAttribute('src');

					// if the img source is 'data-url'
					if (preg_match('/data:image/', $src)) {

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
							->encode($mimetype, 100)// encode file to the specified mimetype
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
		}

		if ($question->answer == null) {
			// create new answer
			$answer = Answer::create([
				'content' => $final_content,
				'user_id' => Auth::user()->id
			]);

			$question->answer_id = $answer->id;

			if ($question->user == null) {
				$question->assigned_to = Auth::user()->id;
			}

			$question->status = 2;
			$question->save();

			Auth::user()->solved_questions++;
			Auth::user()->save();

		} else {
			// update existing answer
			$question->answer->content = $final_content;
			$question->status          = 2;
			$question->answer->user_id = Auth::user()->id;
			$question->answer->save();

			//if ($question->user != null) {
			//	$question->assigned_to = Auth::user()->id;
			//	$question->save();
			//}

		}

		Session::flash('message', 'Vďaka <i class="fa fa-heart"></i> Tvoja odpoveď k otázke bola zaznamenaná.');

		return Redirect::route('questions.show', $id);
	}

	public function updateQuestionStatus($id, $status)
	{

		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		$question = Question::findOrFail($id);

		$question->status = $status;
		$question->save();
		Session::flash('message', 'Status bol zmenený.');

		return back();
	}

	public function commentQuestion(Request $request, $id)
	{

		$data = $request->only(['comment']);

		$validator = Validator::make($data, [
			'comment' => 'required'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator->errors());
		}


		$comment_content = $request->get('comment');

		try {

			$dom = new DomDocument();
			$dom->loadHtml(mb_convert_encoding($comment_content, 'HTML-ENTITIES', "UTF-8"),
				LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

			$images = $dom->getElementsByTagName('img');

			// foreach <img> in the submited message
			foreach ($images as $img) {
				$src = $img->getAttribute('src');

				// if the img source is 'data-url'
				if (preg_match('/data:image/', $src)) {

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
						->encode($mimetype, 100)// encode file to the specified mimetype
						->save(public_path($filepath));

					$new_src = asset($filepath);
					$img->removeAttribute('src');
					$img->setAttribute('src', $new_src);
				} // <!--endif
			} // <!--endforeach

			$final_content = $dom->saveHTML();

		} catch (Exception $e) {
			Session::flash('warning', 'Neplatný HTML kód. Skús pridať komentár ako obyčajný text.');

			return back()->withInput();
		}


		Comment::create([
			'content'     => $final_content,
			'user_id'     => Auth::user()->id,
			'question_id' => $id
		]);

		Session::flash('message', 'Tvoj komentár bol zaznamenaný.');

		return back();
	}

	public function deleteComment($id)
	{

		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		$comment = Comment::findOrFail($id);
		$comment->delete();

		Session::flash('message', 'Komentár bol zmazaný.');

		return back();
	}

	// TODO boilerplate code
	public function updateSubcontent(Request $request, $id)
	{

		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		$question = Question::findOrFail($id);

		$sub_content = $request->get('subcontent');


		if ($sub_content == "<p><br></p>") {
			// delete content
			$question->subcontent = "";
			$question->save();
			Session::flash('message', 'Subcontent deleted.');

			return Redirect::route('questions.show', $id);
		}

		$final_content = $sub_content;

		if (env('ENABLE_IMAGE_UPLOADS', false)) {
			try {

				$dom = new DomDocument();
				$dom->loadHtml(mb_convert_encoding($sub_content, 'HTML-ENTITIES', "UTF-8"),
					LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

				$images = $dom->getElementsByTagName('img');

				// foreach <img> in the submited message
				foreach ($images as $img) {
					$src = $img->getAttribute('src');

					// if the img source is 'data-url'
					if (preg_match('/data:image/', $src)) {

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
							->encode($mimetype, 100)// encode file to the specified mimetype
							->save(public_path($filepath));

						$new_src = asset($filepath);
						$img->removeAttribute('src');
						$img->setAttribute('src', $new_src);
					} // <!--endif
				} // <!--endforeach

				$final_content = $dom->saveHTML();

			} catch (Exception $e) {
				Session::flash('warning', 'Neplatný HTML kód.');

				return back()->withInput();
			}
		}

		$question->subcontent = $final_content;
		$question->save();

		Session::flash('message', 'Subcontent added.');

		return Redirect::route('questions.show', $id);
	}

	public function editSubcontent($id)
	{
		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		return view('questions.subedit')
			->withQuestion(Question::findOrFail($id));
	}

	public function downloadQuestionFile(){

		if(!Auth::user()->isVerified()){
			return Redirect::to('home')->withErrors(['Nemáš oprávnenie stiahnuť si súbor s otázkami.']);
		}

		return response()->download('downloads/'. env('QUESTION_FILE') .
			'.' . env('QUESTION_FILE_EXTENSION'), "otazky_maturita." . env('QUESTION_FILE_EXTENSION'));
	}
	
}
