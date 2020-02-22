<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function post() {
        return $this->hasOne('App\Post');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function roles() {

        // To customize tables name and column follow the format below

        // return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role)id');

        return $this->belongsToMany('App\Role')->withPivot('created_at');
    }

    public function photos() {
        return $this->morphMany('App\Photo', 'imageable');
    }

    public function getNameAttribute($value) {
        return strtoupper($value);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = strtoupper($value);
    }

}
