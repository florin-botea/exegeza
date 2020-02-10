<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Compoships; // for multiple column relationship

class Book extends Model
{
	use SoftDeletes;
	use Compoships;
		 
	protected $fillable = ['index', 'name', 'alias', 'slug', 'type'];

	public function bible ()
	{
		return $this->belongsTo(\App\BibleVersion::class, 'bible_version_id');
	}

	public function chapters ()
	{
		return $this->hasMany(\App\Chapter::class);
	}
	
	public function chapter ()
	{
		return $this->hasOne(\App\Chapter::class);
	}
	
	public function articles ()
	{
		return $this->hasManyThrough(\App\Article::class, \App\ModelHasArticle::class, 'model_id', 'id', 'id', 'article_id');//->where('model_type', $this->__class__);
	}

	public function url()
	{
		return $this->slug;
	}
}
