<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
		use SoftDeletes;
		
    protected $fillable = ['index', 'name'];
}
