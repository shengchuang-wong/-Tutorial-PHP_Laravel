<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Product;
use App\User;
use App\Mail\userCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMailChanged;
use Illuminate\Foundation\Testing\HttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::created(function($user) {
            retry(5, function() use ($user) {
                Mail::to($user->email)->send(new userCreated($user));
            }, 100); // can use $user also since laravel will extract email attribute
        });

        User::updated(function($user) {
            if ($user->isDirty('email')) {
                retry(5, function() use ($user) {
                    Mail::to($user->email)->send(new UserMailChanged($user)); // can use $user also since laravel will extract email attribute
                }, 100); 
            }
        });

        Product::updated(function($product) {
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::UNAVAILABLE_PRODUCT;

                $product->save();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
