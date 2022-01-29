<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletionRequest extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'deadline',
        'user_id'
    ];
}
