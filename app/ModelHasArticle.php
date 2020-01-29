<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelHasArticle extends Model
{
    protected $fillable = ['model_type','model_id','article_id'];
}
