<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use SoftDeletes;
		 
	protected $fillable = ['index', 'name', 'alias', 'slug', 'type'];
		
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
