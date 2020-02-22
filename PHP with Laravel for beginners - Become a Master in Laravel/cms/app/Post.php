<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

	public $directory = "../public/images/";

	use SoftDeletes;

    // protected $table =  'posts';

    // protected $primaryKey = 'post_id';

    protected $date = ['deleted_at'];


	protected $fillable = [
		'title',
		'content',
		'path'
	];


	public function user() {
		return $this->belongsTo('App\User');
	}

	public function photos() {
		return $this->morphMany('App\Photo', 'imageable');
	}

	public function tags() {
		return $this->morphToMany('App\Tag', 'taggable');
	}

	public static function scopeLatest($query) {
		return $query->orderBy('id', 'asc')->get();
	}

	public function getPathAttribute($value) {
		return $this->directory.$value;
	}

}
