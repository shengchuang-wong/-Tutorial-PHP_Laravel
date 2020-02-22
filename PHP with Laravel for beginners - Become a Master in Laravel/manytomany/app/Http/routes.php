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
use App\Role;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/create', function() {

	$user = User::findOrFail(1);

	$role = new Role(['name'=>'Administrator']);

	$user->roles()->save($role);

});


Route::get('/read', function() {

	$user = User::findOrFail(1);

	foreach($user->roles as $role) {
		echo $role->name;
	}

});


Route::get('/update', function() {

	$user = User::findOrFail(1);

	if($user->has('roles')) {
		foreach($user->roles as $role) {
			if ($role->name === 'Administrator') {
				$role->name = 'subscriber';
				$role->save();
			}
		}
	}

});


Route::Get('/delete', function() {

	$user = User::findOrFail(1);

	foreach($user->roles as $role) {
		$role->whereId(5)->delete();
	}

});


Route::get('/attach', function() {

	$user = User::findOrFail(1);

	$user->roles()->attach(2);

});


Route::get('/detach', function() {

	$user = User::findOrFail(1);

	$user->roles()->detach(2);

});


Route::get('/sync', function() {

	$user= User::findOrFail(1);

	$user->roles()->sync([1, 2]);

});