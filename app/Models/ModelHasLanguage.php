<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasLanguage extends Model
{
    protected $fillable = ['model_type','model_id','language_id'];
}
