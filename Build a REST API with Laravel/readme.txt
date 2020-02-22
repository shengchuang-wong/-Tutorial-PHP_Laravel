Readme
======
To create project
-----------------
> composer global require "laravel/installer" <<< download local laravel
> laravel new [project name] <<< create laravel project
Alaternatively, you may use
> composer create-project --prefer-dist laravel/laravel [project name] [version | default is latest]

To generate databased dummy data
--------------------------------
1. database > factories > [New file]
2. database > seeds > DatabaseSeeder.php settings
> php artisan db:seed

To create an api endpoint
-------------------------
1. > php artisan make:controller [name] --resource
2. Inside app > create [Services] > [v1] > [xxxService.php]
<?php

use App\Flight;
namespace App\Services\v1;

class xxx {
	public function getFlights() {
		return Flight::all();
	}
}

3. Go to the controller

use App\Services\v1\FlightService;

protected $flights;
public function __construct(FlightService $service {
	$this->flights = $service;
});

public function index()
{
	$data = $this->flights->getFlights();

	return response()->json($data);
}

?>

4. php artisan make:provider v1/FlightServiceProvider

use App\Services\v1;

public function register() {
	$this->app->bind(FlightService::class, function($app) {
		return new FlightService();
	});
}

5. Go to config > app.php > find Application Service Providers
App\Providers\v1\FlightServiceProvider::class

6. Go to routes > api.php
Route::resource('/v1/flights', v1\FlightController::class);

Make auth by token
==================
1. Go to controller > __construct
$this->middlware('auth:api', ['only' => ['store', 'update', 'destroy']])

2. > php artisan make:auth

3. > php artisan make:migration add_api_token_to_users --table=users

4. Go to migration up
$table->string('api_token', 60)->unique();  

5. Go to User Model
public function save(array $options = []) {
	if (empty($this->api_token)) {
		$this->api_token = str_random(60);
	}

	return parent::save($options);
}

6. > php artisan migrate

To test the auth, use postman header
Authorization: Bearer [token]

Things to remember
==================
1. Go to .env, setup database info (default username is root, password is empty)
2. To restore vendor directory, run the command > composer install

Caution
=======
1. If you meet the problem like
Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table `users` add unique `users_email_unique`(`email`))
Solution:

> go to AppServiceProvider.php
	use Illuminate\Support\Facades\Schema;

> Inside public function boot
	Schema::defaultStringLength(191);


