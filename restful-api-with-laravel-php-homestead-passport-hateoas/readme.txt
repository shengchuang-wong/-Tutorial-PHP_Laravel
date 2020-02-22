To run the repo
===============
> composer install
> php artisan serve
> npm install
> npm run watch

Readme
======
> composer create-project laravel/laravel RESTfulAPI 5.4.* <<< create laravel project with composer
> php artisan serve <<< launch server to serve the project
> php artisan migrate:refresh --seed <<< refresh migration with seeder
> php artisan make:controller [Controller Name] -r -m [Model Name] <<< create controller with implicit binding
> composer require guzzlehttp/guzzle <<< email
> php artisan make:mail [name] <<< create for mail
> php artisan make:mail [name] -m [email.test <<< example] <<< create mail with markdown
> php artisan make:middleware [name] <<< create new middleware
> composer require spatie/laravel-fractal <<< transformer
> composer require laravel/passport <<< for authentication token
> php artisan vendor:publish --tag=passport-components

Mutator
-------
1. Go to Model
setNameAttribute($name) {
        $this->attributes['name'] = strtolower($name);

}

getNameAttribute($name) {
        return ucwords($name);

}

remember that set['column']Atttribute

Implicit Binding
----------------
1. Usually, we use
public function show($id) {
	$user = User::findOrFail($id);

	return $user;
}

2. With implicit binding, we can directly use this
public function show(User $user) {
	return $user;
}

Scope - Works with implicit binding
===================================
1. ScopeFile
<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SellerScope implements Scope {
    
    public function apply(Builder $builder, Model $model) {
        $builder->has('products');
    }

}


?>

2. Model
protected static function boot() {
        
	parent::boot();

        
	static::addGlobalScope(new SellerScope);
    
}

3. Controller
public function show(Seller $seller)
 {
 
	return $this->showOne($seller);
    
}

Image Upload
============
1. Change the default
default => 'local' <<< change to default => 'images'

2. go to app > config > filsystems.php, add this line of codes
'images' => [
            
	'driver' => 'local',
            
	'root' => public_path('img'),
            
	'url' => env('APP_URL').'/storage',
            
	'visibility' => 'public',
       
]

Error Message for Api
=====================
1. In default, some error will return page with useless info, how setup useful one, refer to app > Exception > Handler.php

Middleware
==========
1. php artisan make:middleware [name]
2. Go to app > http > Kernel.php, register your middleware (order is important)

Authentication Token
====================
1. > composer require laravel/passport ^v4 <<< no need ^v3 also can, as long as compatible. If failed, try this
install v1 first, change version within composer.json and run the command composer update

2. Go to config > app, add
Laravel\Passport\PassportServiceProvider::class

3. > php artisan migrate

4. > php artisan passport:install <<< use git bash

5. Go to User Model
use Laravel\Passport\HasApiTokens;
use HasApiTokens;

6. Go to AuthServiceProvider.php, in the boot(), add these lines of code
Passport::routes()

7. Go to api route
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken'); <<< replace from web to api, can check by php artisan route:list

8. config > auth.php , change api => ['driver' => 'token' <<< replace with 'passport']

9. Go to kernel.php, add
        'client.credentials' => \Laravel\Passport\Http\Middleware\CheckClientCredentials::class inside $routeMiddleware

10. To add into Model
public function __construct()
    {
        
	$this->middleware('client.credentials')->only(['index', 'show']);
    
}

11. > php artisan passport:client (0, client, leave empty) <<< use git bash (copy the client id and secret)

12. Go to postman > POST: localhost:8000/oauth/token with body to get the access_token
grant_type => client_credentials
client_id => the copied client id
client_secret => the copied client secret

13. Try to use the access_token as header "Authorization" to access the protected route (try add Bearer before the access_token if token input is not accepted)

14. To protect your model
public function __construct()
    {
        
	$this->middleware('auth:api');
   <<< can use ->except(['index', 'show'])  
}

15. To access more higher privileges like get all users
> php artisan passport:client --password (password)
grant_type => password
client_id => the copied client id
client_secret => the copied client secret
name => [get a registered email]
password => [get the user password]

16. > php artisan vendor:publish --tag=passport-components (delete the Example.vue)

17. use git bash > npm install

18. npm run dev (comment out the Vue.component line inside the app.js) & > npm run watch for next time

19. app.js
Vue.component(
    
'passport-personal-access-tokens', 
    
require('./components/passport/PersonalAccessTokens.vue'));

20. routes > web.php
Route::get('/home/my-tokens', 'HomeController@getTokens')->name('personal-tokens');


21. HomeController.php
public function getTokens()
    {
        
	sreturn view('home.personal-tokens');
    
}

22. Create the view home\personal-tokens.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <passport-personal-access-tokens>

            </passport-personal-access-tokens>
        </div>
    </div>
</div>
@endsection

23. go to app.blade.php
@if (Auth::check())
                        
<li><a href="{{route('personal-tokens')}}">My Tokens</a></li>
                        
@endif

24. If you can't see the view
> php artisan passport:client --personal
If csrf_token() error in console.log, add below codes into the header of layouts.app
<script>
        
window.Laravel = <?php echo json_encode([
            
'csrfToken' => csrf_token()
 ]); ?>
    
</script>

25. 

> php artisan passport:client --password
You can add token expire and refresh in AuthServiceProvider.php

Tips
====
1. /api/ will be serve default. If you want to eliminate it, 
go to app > Providers > RouteServiceProvider and eliminate the prefix('api')
2. VS Code Plugin - PHP Intelephense
3. Method spoofing, some method cannot use form-data, you can bypass by add on more body
_method : put
4. To fix composer require version mismatch with current laravel version, try to use this
composer require [package name] ^v1 <<< ^v1 look like is version, explore it by yourself

Step
====
1. Create Model
2. Create Controller
3. Define Route
4. Set $fillable and $hidden for Model
5. Set migration model attribute

attach < add by duplicate
        
sync < delete all and add
        
syncWithoutDetaching << add without affect current record

