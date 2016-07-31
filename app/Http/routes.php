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

//post
Route::resource('post', 'PostController');

//category
Route::resource('category', 'CategoryController');

//tag
Route::resource('tag', 'TagController', ['except' => ['create']  ]);

//page
Route::group(['prefix'=>'page'], function(){
	Route::get('email', [
	        'uses' => 'PageController@getEmail',
	        'as'   => 'email.form'
		]);
	Route::post('email', [
	        'uses' => 'PageController@postEmail',
	        'as'   => 'email.post'
		]);
});

//comment
Route::resource('comment', 'CommentController', ['except' => ['index', 'create', 'show'] ]);





Route::auth();

Route::get('/home', 'HomeController@index');
