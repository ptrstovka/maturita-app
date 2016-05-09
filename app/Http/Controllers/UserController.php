<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Question;

class UserController extends Controller
{
	public function activateAccount($token)
	{

		$user = User::where('token', $token)->first();

		if ($user == null) {
			return Redirect::to('login')->withErrors(['Aktivačný link je neplatný.']);
		}

		if ($user->is_activated) {
			Session::flash('info', 'Tvoj účet už je aktivovaný.');

			return Redirect::to('login');
		}

		$user->activate();

		// shuffle some questions :)

		$questions = Question::where('assigned_to', 0)->where('category_id', 1)->get();

		for ($i = 0; $i < 8; $i++) {
			$num                          = random_int(0, count($questions) - 1);
			$questions[$num]->assigned_to = $user->id;
			$questions[$num]->status      = 1;
			$questions[$num]->save();
		}


		Session::flash('message', 'Tvoj účet bol úspešne aktivovný. Môžeš sa prihlásť.');

		return Redirect::to('login');
	}

	public function createUser(Request $request)
	{

		if(env('DISABLE_REGISTRATIONS', true)) {
			return back()->withErrors(['Registrácie sú zastavené.']);
		}

		$data = $this->getUserCreateFields($request);

		$validator = Validator::make($data, [
			'first_name' => 'required|max:255',
			'last_name'  => 'required|max:255',
			'email'      => 'required|email|max:255|unique:users',
			'password'   => 'required|min:8|confirmed',
		]);

		if (env('REQUIRE_VALID_MAIL', true)) {
			if (!ends_with($data['email'], '@spse-po.sk')) {
				return back()->withErrors(['Musíš použiť školsku emailovú adresu.'])->withInput();
			}
		}

		if ($validator->fails()) {
			return back()->withErrors($validator->errors())->withInput();
		}

		// means everything okay
		$user = User::create([
			'first_name' => $data['first_name'],
			'last_name'  => $data['last_name'],
			'email'      => $data['email'],
			'password'   => bcrypt($data['password']),
			'token'      => strtolower(str_random(32))
		]);

		// add first category
		$user->categories()->sync([1]);

		if (env('SEND_EMAILS', true)) {
			$user->sendActivationEmail();
		}

		Session::flash('message', 'Tvoj účet bol úspešne vytvorený. 
		Avšak aby sme zachovali všetko v tajnosti, musím overiť, či zadaná emailová adresa fakt patrí tebe. 
		Skontroluj si svoju poštu. Bol ti zaslaný aktivačný link.');


		//return back();

		return Redirect::to('login');

	}

	private function getUserCreateFields(Request $request)
	{
		return $request->only([
			'first_name',
			'last_name',
			'email',
			'password',
			'password_confirmation'
		]);
	}

	public function indexUsers()
	{

		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		return view('users.index')
			->withUsers(User::all());
	}

	public function showUser($id)
	{

		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		$user       = User::findOrFail($id);
		$categories = Category::all();

		return view('users.show')
			->withUser($user)
			->withCategories($categories);
	}

	public function updateUser(Request $request, $id)
	{

		if (!Auth::user()->isAdmin()) {
			return abort(404);
		}

		$user = User::findOrFail($id);

		$data = $request->only(['first_name', 'last_name']);

		$validator = Validator::make($data, [
			'first_name' => 'required',
			'last_name'  => 'required',
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator->errors());
		}

		$categories = $request->get('categories');
		$user->categories()->sync($categories);
		$user->first_name = $data['first_name'];
		$user->last_name  = $data['last_name'];
		$user->save();


		Session::flash('message', 'Užívateľ bol aktualizovaný.');

		return back();
	}

}
