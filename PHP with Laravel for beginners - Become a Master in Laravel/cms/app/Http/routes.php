<?php

use App\Post;
use App\User;
use App\Country;
use App\Photo;
use App\Tag;
use App\Role;
use Carbon\Carbon;

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

// Route::get('/about', function () {
//     return "Hi about page";
// });

// Route::get('/contact', function () {
//     return "Hi contact page";
// });

// Route::get('/post/{id}/{name}', function ($id, $name) {
//     return "This is ID: ".$id." ".$name;
// });

// Route::get('admin/posts/example', array( 'as' => 'admin.home', function() {
// 	$url = route('admin.home');
// 	return "This url is ".$url;
// }));

// Route::get('/post/{id}', 'PostsController@index');

// Route::resource('posts', 'PostsController');

// Route::get('/contact', 'PostsController@contact');

// Route::get('/post/{id}', 'PostsController@show_post');



/*
-------------------------
Database Raw SQL Queries
-------------------------
*/

// Route::get('/insert', function() {
// 	DB::insert('insert into posts(title, content) value(?, ?)', ['PHP with Kino', 'Laravel is the best framework for Kino']);
// });


// Route::get('/read', function() {
// 	$results = DB::select('select * from posts where id = ?', [1]);

// 	return $results;

// 	// foreach($results as $post) {
// 	// 	return $post->title;
// 	// }
// });


// Route::get('/update', function() {

// 	$updated = DB::update('update posts set title = "Update title" where id = ?', [1]);

// 	return $updated;

// });


// Route::get('/delete', function() {
// 	$deleted = DB::delete('delete from posts where id = ?', [1]);

// 	return $deleted;
// });


/*
-------------------------
ELOQUENT - ORM
-------------------------
*/

// Route::get('/find', function() {

// 	$posts = Post::all();

// 	foreach($posts as $post) {
// 		return $post->title;
// 	}

// });

// Route::get('/find', function() {

// 	$post = Post::find(2);

// 	return $post->title;

// });


// Route::get('/findwhere', function() {

// 	$posts = Post::where('id', 2)->orderBy('id', 'desc')->take(1)->get();

// 	return $posts;

// });

// Route::get('/findmore', function() {

// 	// $posts = Post::findOrFail(1);

// 	// return $posts;

// 	// $posts = Post::where('users_count', '<', 50)->firstOrFail();


// });


// Route::get('/basicinsert', function() {

// 	$post = new Post;

// 	$post->title = 'New Eloquent title insert';
// 	$post->content = 'Wow eloquent is pretty cool';

// 	$post->save();

// });

// Route::get('/basicinsert2', function() {

// 	$post = Post::find(2);

// 	$post->title = 'New Eloquent title insert 2';
// 	$post->content = 'Wow eloquent is pretty cool 2';

// 	$post->save();

// });


// Route::get('/create', function() {

// 	Post::create(['title'=>'the create method', 'content'=>'WOW I am learning Laravel']);

// });


// Route::get('/update', function() {

// 	Post::where('id', 2)->where('is_admin', 0)->update(['title'=>'NEW PHP TITLE', 'content'=>'hahahahaha']);

// });


// Route::get('/delete', function() {
// 	$post = Post::find(2);

// 	$post->delete();
// });

// Route::get('/delete2', function() {

// 	Post::destroy([3,4,5]);

// });


// Route::get('/softdelete', function() {
// 	Post::find(1)->delete();
// });


// Route::get('/readsoftdelete', function() {

	// $post = Post::find(1);

	// return $post;

	// $post = Post::withTrashed()->where('is_admin', 0)->get();

	// return $post;

	// $post = Post::onlyTrashed()->where('is_admin', 0)->get();

	// return $post;

// });


// Route::get('/restore', function() {

// 	Post::withTrashed()->where('is_admin', 0)->restore();

// });


// Route::get('/forcedelete', function() {
// 	Post::onlyTrashed()->where('is_admin', 0)->forcedelete();
// });


/*
-------------------------
ELOQUENT Relationships
-------------------------
*/

// 1 TO 1 Relationship
// Route::get('/user/{id}/post', function($id) {

// 	return User::find($id)->post;

// });


// Route::get('/post/{id}/user', function($id) {

// 	return Post::find($id)->user->name;

// });


// 1 TO * Relationship
// Route::get('/posts', function() {

// 	$user = User::find(1);

// 	foreach($user->posts as $post) {
// 		echo $post->title . "<br>";
// 	}

// });


// * To * Relationship
// Route::get('/user/{id}/role', function($id) {
// 	$user = User::find($id);

// 	foreach($user->roles as $role) {
// 		return $role->name;
// 	}


// 	$user = User::find($id)->roles()->orderBy('id', 'desc')->get();

// 	return $user;

// });


// Accessing the intermediate table / pivot
// Route::get('/user/pivot', function() {

// 	$user = User::find(1);

// 	foreach($user->roles as $role) {
// 		echo $role->pivot->created_at;
// 	}

// });


// Route::get('/user/country', function() {
// 	$country = Country::find(1);

// 	foreach($country->posts as $post) {
// 		return $post->title;
// 	}
// });



// Polymorphic Relationship

// Route::get('/user/{id}/photo', function($id) {
// 	$user = User::find($id);

// 	foreach($user->photos as $photo) {
// 		return $photo->path;
// 	}
// });

// Route::get('/post/{id}/photo', function($id) {
// 	$post = Post::find($id);

// 	foreach($post->photos as $photo) {
// 		echo $photo->path . "<br>";
// 	}
// });


// Route::get('photo/{id}/post', function($id) {
// 	$photo = Photo::findorFail($id);

// 	return $photo->imageable;
// });

// Polymorphic * TO *
// Route::get('/post/tag', function() {
// 	$post = Post::find(1);

// 	foreach($post->tags as $tag) {
// 		echo $tag->name;
// 	}
// });


// Route::get('/tag/post', function() {

// 	$tag = Tag::find(2);

// 	foreach($tag->posts as $post) {
// 		echo $post->title;
// 	}

// });


/*
--------------------
 CRUD Application
--------------------
*/



/*
--------------------
 Application Routes
--------------------
*/


Route::group(['middlewareGroups' => 'web'], function() {
	Route::resource('/posts', 'PostsController');

	Route::get('/dates', function() {
		$date = new DateTime("+1 week");

		echo $date->format('m-d-Y');

		echo "<br>";

		echo Carbon::now()->addDays(10)->diffForHumans();

		echo "<br>";

		echo Carbon::now()->subMonths(5)->diffForHumans();

		echo "<br>";

		echo Carbon::now()->yesterday()->diffForHumans();

		echo "<br>";


		echo "<br>";

	});

	Route::get('/getname', function() {
		$user = User::findOrFail(1);

		echo $user->name;
	});

	Route::get('/setname', function() {
		$user = User::findOrFail(1);

		$user->name = "william";

		$user->save();
	});

});