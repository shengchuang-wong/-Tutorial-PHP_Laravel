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

use App\User;
use App\Post;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/create', function() {
	$user = User::findOrFail(1);

	$post = new Post(['title'=>'My second post with King', 'body'=> 'Laravel is simple']);

	$user->posts()->save($post);
});


Route::get('/read', function() {

	$user = User::findOrFail(1);

	foreach($user->posts as $post) {
		echo $post->title . "<br>";
	}

});


Route::get('/update', function() {

	$user = User::findOrFail(1);

	$user->posts()->whereId(1)->update(['title'=>'Edited Title', 'body'=>'haha New']);

});


Route::get('/delete', function() {

	$user = User::findOrFail(1);

	$user->posts()->whereId(1)->delete();

});