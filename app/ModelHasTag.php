<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelHasTag extends Model
{
    protected $fillable = ['model_type', 'tag_id', 'user_id'];
}
