<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('user/activate/{token}', ['as' => 'user.activate', 'uses' => 'UserController@activateAccount']);
Route::get('user/invite/accept/{token}', ['as' => 'user.invite', 'uses' => 'UserController@acceptInvitation']);
Route::post('user/create', ['as' => 'user.create', 'uses' => 'UserController@createUser']);
Route::post('user/invite/register', ['as' => 'user.invite.register', 'uses' => 'UserController@registerInvitedUser']);

Route::group(['middleware' => 'auth'], function() {

	Route::get('questions/download',['as' => 'questions.download', 'uses' => 'QuestionController@downloadQuestionFile']);
	Route::get('questions/all/{category}', ['as' => 'questions.all', 'uses' => 'QuestionController@indexAll']);
	Route::get('questions/user/{category}', ['as' => 'questions.user', 'uses' => 'QuestionController@userQuestions']);
	Route::get('question/{id}', ['as' => 'questions.show', 'uses' => 'QuestionController@showQuestion']);
	Route::get('question/edit/{id}', ['as' => 'questions.edit', 'uses' => 'QuestionController@editQuestion']);
	Route::post('question/edit/{id}', ['as' => 'questions.update', 'uses' => 'QuestionController@updateQuestion']);
	Route::post('question/comment/{id}', ['as' => 'questions.comment', 'uses' => 'QuestionController@commentQuestion']);
	Route::get('question/comment/delete/{id}', ['as' => 'questions.comment.delete', 'uses' => 'QuestionController@deleteComment']);
	Route::get('question/update/{id}/{status}', ['as' => 'questions.update.status', 'uses' => 'QuestionController@updateQuestionStatus']);
	Route::post('question/update/subcontent/{id}', ['as' => 'questions.update.subcontent', 'uses' => 'QuestionController@updateSubcontent']);
	Route::get('question/edit/subcontent/{id}', ['as' => 'questions.edit.subcontent', 'uses' => 'QuestionController@editSubcontent']);
	
	Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@indexUsers']);
	Route::get('user/{id}', ['as' => 'users.show', 'uses' => 'UserController@showUser']);
	Route::post('user/update/{id}', ['as' => 'users.update', 'uses' => 'UserController@updateUser']);
    Route::get('user/invite/email', ['as' => 'users.invite.show', 'uses' => 'UserController@showInvitePage']);
    Route::post('user/invite/email', ['as' => 'users.invite', 'uses' => 'UserController@sendInvitation']);
    Route::get('user/password/change', ['as' => 'users.password.show', 'uses' => 'UserController@showPasswordChangePage']);
    Route::post('user/password', ['as' => 'users.password', 'uses' => 'UserController@changePassword']);
	
});
