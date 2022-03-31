<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Awobaz\Compoships\Compoships; // for multiple column relationship

class Book extends Model
{
	use SoftDeletes;
	use Compoships;

	protected $fillable = ['index', 'name', 'alias', 'slug', 'version', 'type'];

	public function bible ()
	{
		return $this->belongsTo(BibleVersion::class, 'bible_version_id');
	}

	public function chapters ()
	{
		return $this->hasMany(Chapter::class);
	}

	public function chapter ()
	{
		return $this->hasOne(Chapter::class);
	}

	public function verses ()
	{
		return $this->hasMany(Verse::class);
	}

	public function articles ()
	{
		return $this->hasManyThrough(Article::class, ModelHasArticle::class, 'model_id', 'id', 'id', 'article_id');//->where('model_type', $this->__class__);
	}

	public function url()
	{
		return $this->slug;
	}
}
