<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasTag extends Model
{
    protected $fillable = ['model_type', 'model_id', 'tag_id', 'user_id'];
}
