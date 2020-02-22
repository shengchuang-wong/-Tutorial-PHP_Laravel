use Illuminate\Support\Facades\Auth;


php artisan make:migration migration_name --table=posts
php artisan make:migration migration_name --create=newTable
php artisan migrate:rollback
php artisan migrate:reset
php artisan migrate:refresh
php artisan migrate
php artisan make:auth
php artisan route:list

php artisan make:seed UsersTableSeeder
php artisan db:seed

php artisan make:model model_name -m

composer create-project --prefer-dist laravel/laravel projectname 5.2.29

Settings
--------
config/app.php

debug -> true

cipher -> someRandomString
php artisan key:generate
.env.example APP_KEY

goto config/database.php
change database information such as name, username, and password


php artisan make:controller ControllerName

Scope
-----
$user->date	
public function getDateAttribute

->latestFirst()
public function scopeLatestFirst

Paging
------
At the last of scope
->paginate(3)
Go to view
{{ $users->links() }}

Relationship
------------
In Post
public function author() {
	return $this->belongsTo(User::class);
}
$post->author->name

In User
public function posts() {
	return $this->hasMany(Post::class);
}

AND index() {
	$posts = Post::all();
	changed To
	$posts = Post::with('author')->get();
}


Token in form
-------------
csrf_form()

Form
----
function xxx(Request request) {
$user = new User;
$user->name = $request->name;
$user->save();
}

Custom Request
--------------
php artisan make:request UserRequest
rules() {
	return [
		'name' => 'required',
		'email' => 'required|email'	
	]
}

use App\Http\Requests\UserRequest
// show error
@foreach($errors->all() as $error) {
	echo $error;
}

Custom Error Message
public function messages() {
	return [
		'name.requried' => 'name is required'
	]
}

Go to Model
protected $fillable = ['name', 'email']; // only fill up this two columns
$user = User::create(['name'=>$request->name, "email"=>$request->email]);

Show Message after form submission
----------------------------------
use Session;

after ->save();
Session::flash('msg', 'Data is saved');
return back;

In VIEW
{{ Session::get('msg') }};

Authentication
--------------
Auth::check() <-- check is authenticated

Auth::logout() <-- logout user

Auth::guest() <-- check is guest

return Redirect::to('login);

Auth::user()->email <-- get logged in user email

Manually log in
if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
    // The user is active, not suspended, and exists.
 return redirect()->intended('dashboard');
}

Authenticate User
Auth::login($user);
Auth::loginUsingId(1);